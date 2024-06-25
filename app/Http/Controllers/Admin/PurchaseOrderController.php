<?php

namespace App\Http\Controllers\Admin;

use App\Interfaces\PurchaseOrderInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderProduct;
use App\Models\PurchaseOrderBox;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Stock;
use App\Models\StockProduct;
use App\Models\StockBox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PurchaseOrderController extends Controller
{
    // public PurchaseOrderInterface $PurchaseOrderRepository;
    public function __construct(PurchaseOrderInterface $PurchaseOrderRepository,Request $request)
    {
        $this->PurchaseOrderRepository = $PurchaseOrderRepository;
        $this->middleware('auth:web');
        $this->middleware(function ($request, $next) {
            $this->id = Auth::user()->id;
            $this->type = Auth::user()->type;
            $this->designation = Auth::user()->designation;
            // dd($this->type);
            if($this->type == 2){
                $userAccesses = userAccesses($this->designation,8);
                if(!$userAccesses){
                    abort(401);
                }
            }

            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $type = !empty($request->type)?$request->type:'po';
        $product = !empty($request->product)?$request->product:'';
        $product_name = !empty($request->product_name)?$request->product_name:'';
        $paginate = 10;
        $total = PurchaseOrder::count();
        
        $data = PurchaseOrder::select('*')
        ->withCount(['purchase_order_products' => function($q){
            $q->select(DB::raw('SUM(qty) AS total_qty'));
        }]);
        
        $total = PurchaseOrder::select('id');
        
        if(!empty($product)){
            $purchase_order_products = PurchaseOrderProduct::where('product_id',$product)->get();
            if(!empty($purchase_order_products)){
                foreach($purchase_order_products as $po){
                    $ids[] = $po->purchase_order_id;
                }
            }
            $data = $data->whereIn('id',$ids);
            $total = $total->whereIn('id',$ids);
        } 
        
        $data = $data->orderBy('id','desc')->paginate($paginate);
        $total = $total->count();

        $data = $data->appends([
            'type' => $type,
            'product'=>$product,
            'product_name'=>$product_name,
            'page'=>$request->page
        ]);

        
        // echo $total; die;
        // dd($data);
        return view('admin.purchaseorder.index', compact('data','product','product_name','total','type','paginate'));
    }

    public function create(Request $request,$supplier_id=0)
    {
        $products = $supplier_details = array();        
        $products = DB::table('products')->select('id','name')->where('status', 1)->orderBy('name','asc')->get();
        
        $suppliers = Supplier::where('status',1)->get();
        if(!empty($supplier_id)){
            $supplier_details = Supplier::find($supplier_id);
        }
        // dd($suppliers);
        $app_settings = DB::table('app_settings')->find(1);
        return view('admin.purchaseorder.create', compact('products', 'suppliers','app_settings','supplier_details','supplier_id'));
    }

    public function store(Request $request)
    {
        # store...
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'details.*.product_id' => 'required',            
            'details.*.hsn_code' => 'required',
            'details.*.pcs' => 'required|not_in:0',
            'details.*.weight' => 'required',
            'details.*.weight_unit' => 'required',
            'details.*.piece_price' => 'required|not_in:0',
            'details.*.qty' => 'required|not_in:0'            
        ],[
            'details.*.product_id.required' => 'Please add product',
            'details.*.hsn_code.required' => 'Please add hsn code of product',
            'details.*.pcs.required' => 'Please add pices per carton',
            'details.*.pcs.not_in' => 'Please add pices per carton',
            'details.*.weight.required' => 'Please add weight per carton',
            'details.*.weight_unit.required' => 'Please add carton weight unit',
            'details.*.piece_price.required' => 'Please add price per piece',
            'details.*.piece_price.not_in' => 'Please add price per piece',
            'details.*.qty.required' => 'Please add number of carton',
            'details.*.qty.not_in' => 'Please add number of carton'
        ]);

        $params = $request->except('_token');
        // dd($params);
        $details = $params['details'];
        $idsArr = array();
        $po_total_price = 0;
        foreach($details as $item){
            // dd($item['product_id']);
            $idsArr[] = $item['product_id'];
            $po_total_price += $item['total_price'];
        }
        // dd($idsArr);
        $product_ids = implode(",",$idsArr);
        // die;

        $purchase_orders_data = array(
            'unique_id' => $params['unique_id'],
            'supplier_id' => $params['supplier_id'],     
            'product_ids' => $product_ids,           
            'address' => $params['address'],
            'state' => $params['state'],
            'city' => $params['city'],
            'country' => $params['country'],
            'pin' => $params['pin'],    
            'total_price' => $po_total_price,   
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')               
        );
        $purchase_order_id = PurchaseOrder::insertGetId($purchase_orders_data);

        foreach($details as $item){
            if($item['weight_unit'] == 'kg'){
                $item['weight_value'] = ($item['weight'] * 1000);
            } else {
                $item['weight_value'] = $item['weight'];
            }

            PurchaseOrderProduct::insert([
                'purchase_order_id' => $purchase_order_id,
                'product_id' => $item['product_id'],
                'product' => $item['product'],
                'qty' => $item['qty'],
                'pcs' => $item['pcs'],
                'unit_price' => $item['price_per_carton'],
                'piece_price' => $item['piece_price'],
                'total_price' => $item['total_price'],
                'hsn_code' => $item['hsn_code'],
                'weight' => $item['weight'],
                'weight_unit' => $item['weight_unit'],
                'weight_value' => $item['weight_value'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            /* Update product threshold and sell price */
            $updateProductSellPrice = updateProductSellPrice($item['price_per_carton'],$item['piece_price'],$item['product_id']);
            Product::where('id',$item['product_id'])->update([                        
                'hsn_code' => $item['hsn_code']
            ]);

            for($j=0;$j < ($item['qty']); $j++){
                $barcodeGen = genAutoIncreNoBarcode($item['product_id'],date('Y'));
                $barcode_no = $barcodeGen['barcode_no'];
                $code_html = $barcodeGen['code_html'];
                $code_base64_img = $barcodeGen['code_base64_img'];
                PurchaseOrderBox::insert([
                    'purchase_order_id' => $purchase_order_id,
                    // 'po_uniquie_id' => $params['unique_id'],
                    'product_id' => $item['product_id'],
                    'pcs' => $item['pcs'],
                    'barcode_no' => $barcode_no,
                    'code_html' => $code_html,
                    'code_base64_img' => $code_base64_img,
                    'po_weight_val' => $item['weight_value']
                ]);
            }

        }

        /* changelogentry */
        $details['po_uniquie_id'] = $params['unique_id'];
        changelogentry(Auth::user()->id,'add_po',json_encode($details));

        Session::flash('message', 'Purchase order created successfully');
        return redirect()->route('admin.purchaseorder.index', ['type'=>'po']);
    }

    public function show(Request $request, $id)
    {
        $code_html_arr = array();
        $po = PurchaseOrder::find($id);
        $unique_id = $po->unique_id;
        $data = PurchaseOrderProduct::where('purchase_order_id',$id)->get();
        
        return view('admin.purchaseorder.detail', compact('po','id','unique_id','data'));
    }

    public function barcodes(Request $request,$id)
    {
        $purchase_order_boxes = PurchaseOrderBox::where('purchase_order_id',$id)->where('is_archived', 0)->get();

        return view('admin.purchaseorder.barcode', compact('purchase_order_boxes','id'));
    }

    
    public function edit(Request $request, $id)
    {
        $po = PurchaseOrder::find($id);
        $data = PurchaseOrderProduct::where('purchase_order_id',$id)->get();

        // dd($data);       
        $suppliers = $this->PurchaseOrderRepository->supplierList();
        $supplier_details = Supplier::find($data[0]->supplier_id);

        $products = DB::table('products')->where('status',1)->orderBy('name','asc')->get();
        return view('admin.purchaseorder.edit', compact('po','data', 'products', 'supplier_details'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'details.*.product_id' => 'required',            
            'details.*.hsn_code' => 'required',
            'details.*.pcs' => 'required|not_in:0',
            'details.*.weight' => 'required',
            'details.*.weight_unit' => 'required',
            'details.*.piece_price' => 'required|not_in:0',
            'details.*.qty' => 'required|not_in:0'            
        ],[
            'details.*.product_id.required' => 'Please add product',
            'details.*.hsn_code.required' => 'Please add hsn code of product',
            'details.*.pcs.required' => 'Please add pices per carton',
            'details.*.pcs.not_in' => 'Please add pices per carton',
            'details.*.weight.required' => 'Please add weight per carton',
            'details.*.weight_unit.required' => 'Please add carton weight unit',
            'details.*.piece_price.required' => 'Please add price per piece',
            'details.*.piece_price.not_in' => 'Please add price per piece',
            'details.*.qty.required' => 'Please add number of carton',
            'details.*.qty.not_in' => 'Please add number of carton'
        ]);

        $params = $request->except('_token');        
        $details = $params['details'];

        // dd($params);

        PurchaseOrder::where('id',$params['id'])->update([
            'total_price' => $params['total_po_price'],
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        
        
        foreach($details as $item){
            if($item['weight_unit'] == 'kg'){
                $item['weight_value'] = ($item['weight'] * 1000);
            } else {
                $item['weight_value'] = $item['weight'];
            }
            PurchaseOrderProduct::where('purchase_order_id',$params['id'])->where('product_id',$item['product_id'])->update([
                'qty' => $item['qty'],
                'pcs' => $item['pcs'],
                'unit_price' => $item['price_per_carton'],
                'piece_price' => $item['piece_price'],
                'total_price' => $item['total_price'],
                'hsn_code' => $item['hsn_code'],
                'weight' => $item['weight'],
                'weight_unit' => $item['weight_unit'],
                'weight_value' => $item['weight_value'],
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            /* Update product threshold and sell price */
            $updateProductSellPrice = updateProductSellPrice($item['price_per_carton'],$item['piece_price'],$item['product_id']);
            Product::where('id',$item['product_id'])->update([                        
                'hsn_code' => $item['hsn_code']
            ]);

            if($item['isNoCtnChanged'] == 1){
                if($item['qty'] > $item['oldCtnNo']){
                    $rest = ($item['qty'] - $item['oldCtnNo']);
                    // echo 'product_id:- '.$item['product_id'].' Add New:- '.$rest;
                    // echo '<br/>';
                    for($j=0;$j < ($rest); $j++){
                        $barcodeGen = genAutoIncreNoBarcode($item['product_id'],date('Y'));
                        $barcode_no = $barcodeGen['barcode_no'];
                        $code_html = $barcodeGen['code_html'];
                        $code_base64_img = $barcodeGen['code_base64_img'];
                        PurchaseOrderBox::insert([
                            'purchase_order_id' => $params['id'],
                            // 'po_uniquie_id' => $params['unique_id'],
                            'product_id' => $item['product_id'],
                            'pcs' => $item['pcs'],
                            'barcode_no' => $barcode_no,
                            'code_html' => $code_html,
                            'code_base64_img' => $code_base64_img,
                            'po_weight_val' => $item['weight_value']
                        ]);
                    }

                } else {
                    $rest = ($item['oldCtnNo'] - $item['qty']);
                    // echo 'product_id:- '.$item['product_id'].' Delete Old:- '.$rest;
                    // echo '<br/>';
                    $old_rest_box = PurchaseOrderBox::where('purchase_order_id',$params['id'])->where('product_id',$item['product_id'])->orderBy('id','desc')->take($rest)->delete();

                }
            }

            
        
        }

        /* changelogentry */
        $details['po_uniquie_id'] = $params['unique_id'];
        changelogentry(Auth::user()->id,'edit_po',json_encode($details));

        // dd($params);

        Session::flash('message', 'Purchase order updated successfully');
        return redirect()->route('admin.purchaseorder.index', ['type'=>'po']);
    }

    public function showboxes(Request $request,$id)
    {
        $search = !empty($request->search)?$request->search:'';
        
        $data = PurchaseOrderBox::with('product')->where('purchase_order_id',$id)->where('is_archived', 0);  
        $totalData = PurchaseOrderBox::with('product')->where('purchase_order_id',$id)->where('is_archived', 0);  
        if(!empty($search)){
            $data = $data->where(function($q) use ($search){
                $q->where('barcode_no','LIKE', '%'.$search.'%')->orWhereHas('product', function ($product) use ($search) {
                    $product->where('name', 'LIKE','%'.$search.'%');
                });
            });

            $totalData = $totalData->where(function($q) use ($search){
                $q->where('barcode_no','LIKE', '%'.$search.'%')->orWhereHas('product', function ($product) use ($search) {
                    $product->where('name', 'LIKE','%'.$search.'%');
                });
            });
        }
        $data = $data->get()->sortBy('product_id')->groupBy('product.id');
        $totalData = $totalData->count();
        // dd($data);
        
        return view('admin.purchaseorder.showboxes', compact('data','totalData','search','id'));
    }

    public function grn(Request $request,$id)
    {
        # code...
        $search = !empty($request->search)?$request->search:'';
        $goods_in_type = !empty($request->goods_in_type)?$request->goods_in_type:'';
        $purchaseorder = PurchaseOrder::find($id);
        $unique_id = $purchaseorder->unique_id;

        $data = PurchaseOrderBox::with('product')->where('purchase_order_id',$id)->where('is_archived', 0)->where('is_goods_in', 0);        
        if(!empty($search)){
            $data = $data->where(function($q) use ($search){
                $q->where('barcode_no','LIKE', '%'.$search.'%')->orWhereHas('product', function ($product) use ($search) {
                    $product->where('name', 'LIKE','%'.$search.'%');
                });
            });
        }
        $data = $data->get()->sortBy('product_id')->groupBy('product.id');  

        if(!empty($goods_in_type)){
            PurchaseOrder::where('id',$id)->update(['goods_in_type'=>$goods_in_type]);
        }

        $total_checked = PurchaseOrderBox::where('purchase_order_id',$id)->where('is_archived', 0)->where(function($q){
            $q->where('is_scanned', 1)->orWhere('is_bulk_scanned', 1);
        })->count();

        // dd($total_checked);

        return view('admin.purchaseorder.grn', compact('purchaseorder','goods_in_type','data','unique_id','id','search','total_checked'));
    }

    public function pobulkscan(Request $request)
    {
        # PO Bulk Scan...

        // dd($request->all());

        $purchase_order_id = !empty($request->purchase_order_id)?$request->purchase_order_id:'';
        $product_id = !empty($request->product_id)?$request->product_id:'';
        $is_bulk_scanned = $request->is_bulk_scanned;
        $is_scanned = $request->is_scanned;
        $data = PurchaseOrderBox::where('purchase_order_id',$purchase_order_id)->where('product_id',$product_id)->where(function($q){
            $q->where('is_scanned', 0)->orWhere('is_bulk_scanned', 0);
        })->get();

        // dd($data);
        
        if(!empty($data)){
            foreach($data as $item){
                PurchaseOrderBox::where('id',$item->id)->update([
                    'is_bulk_scanned'=>$is_bulk_scanned,
                    // 'is_goods_in'=>$is_scanned
                ]);
            }
        }

        return 1;
        
    }

    public function archiveBox($id,$product_id,$barcode_no,$getQueryString='')
    {
        # remove box and archive box to another place ...

        $purchase_order_box =  PurchaseOrderBox::where('purchase_order_id',$id)->where('product_id',$product_id)->where('barcode_no',$barcode_no)->first();

        if(!empty($purchase_order_box)){
            // dd($getQueryString);
            PurchaseOrderBox::where('id',$purchase_order_box->id)->update([
                'is_archived' => 1
            ]);

            $po = PurchaseOrderProduct::where('purchase_order_id',$id)->where('product_id',$product_id)->first();
            $qty = $po->qty;
            $qty = $qty-1;
            /* Substraction from total amount */
            $unit_price = $po->unit_price;
            $total_price = $po->total_price;
            $new_total_price = ($total_price - $unit_price);
            // echo $qty; exit;
            PurchaseOrderProduct::where('purchase_order_id', $id)->where('product_id',$product_id)->update(['qty' => $qty , 'total_price' => $new_total_price]);
            $total_po_price = PurchaseOrderProduct::where('purchase_order_id',$id)->sum('total_price');
            PurchaseOrder::where('id',$id)->update(['total_price'=>$total_po_price]);

            Session::flash('message', 'Carton '.$barcode_no.' is archived suceesfully'); 
            return redirect()->route('admin.purchaseorder.grn', [$id,$getQueryString]);
            
        } else {
            return  redirect()->back()->withInput();
        }
        
    }

    public function archivedBoxes($unique_id)
    {
        # code...
        $data = DB::table('purchase_order_archived_boxes AS poab')->select('poab.*','products.name AS pro_name','purchase_orders.status')->leftJoin('products', 'products.id','poab.product_id')->leftJoin('purchase_orders', 'purchase_orders.id','poab.po_id')->where('poab.po_uniquie_id',$unique_id)->get()->toarray();

        // dd($data);
        return view('admin.purchaseorder.archived', compact('unique_id','data'));
    }

    public function saveinventory(Request $request)
    {
        $grn_no = getRandString(16);
        $params = $request->except('_token');
        $request->validate([
            'barcode_no' => 'required'
        ]);

        // dd($params);

        $stock_id = Stock::insertGetId([
            'purchase_order_id' => $params['id'],
            'po_unique_id' => $params['unique_id'],
            'goods_in_type' => $params['goods_in_type'],
            'grn_no' => $grn_no,
            // 'product_ids' => $product_ids,    
        ]);

        $products = $params['products'];
        $proids = array();
        $product_ids = '';
        foreach($products as $item){
            if(!empty($item['count_scanned'])){
                $proids[] = $item['product_id'];
                StockProduct::insert([
                    'stock_id' => $stock_id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['count_scanned'],
                    'unit_price' => $item['unit_price'],
                    'piece_price' => $item['piece_price'],
                    'total_price' => ($item['count_scanned'] * $item['unit_price'])
                ]);
                $product_ids = implode(",",$proids);
            }
            
        }

        $total_stock_price = StockProduct::where('stock_id',$stock_id)->sum('total_price');
        Stock::where('id',$stock_id)->update([
            'product_ids' => $product_ids,
            'total_price' => $total_stock_price
        ]);
        // die;
        $barcode_no = $params['barcode_no'];
        PurchaseOrderBox::whereIn('barcode_no',$barcode_no)->update(['is_goods_in' => 1]);

        
        foreach($barcode_no as $barcode){
            $getBarcodeDetails = getBarcodeDetails($barcode);
            StockBox::insert([
                'stock_id' => $stock_id,
                'product_id' => $getBarcodeDetails['product_id'],
                'pcs' => $getBarcodeDetails['pcs'],
                'barcode_no' => $barcode,
                'code_html' => $getBarcodeDetails['code_html'],
                'code_base64_img' => $getBarcodeDetails['code_base64_img'],
                'stock_in_weight_val' => $getBarcodeDetails['po_weight_val'] 
            ]);
        }

        $total_box = PurchaseOrderBox::where('purchase_order_id',$params['id'])->where('is_archived', 0)->count();
        $total_scanned_box = PurchaseOrderBox::where('purchase_order_id',$params['id'])->where('is_archived', 0)->where('is_goods_in', 1)->count();

        if($total_box == $total_scanned_box){
            PurchaseOrder::where('id',$params['id'])->update([
                'status' => 2
            ]);
        }

        $purchase_order = PurchaseOrder::find($params['id']);
        $supplier_id = $purchase_order->supplier_id;
        /* Supplier Ledger Entry */
        DB::table('ledger')->insert([
            'user_type' => 'supplier',
            'supplier_id' => $supplier_id,
            'transaction_id' => $grn_no,
            'transaction_amount' => $total_stock_price,
            'entry_date' => date('Y-m-d'),
            'is_credit' => 1,'purpose' => 'goods_received_note',
            'purpose_description' => 'Goods Received Note'
        ]);
        /* changelogentry */
        changelogentry(Auth::user()->id,'grn',json_encode($params));
        

        $successMsg = "Stock inventory has been generated with GRN successfully";        
        Session::flash('message', $successMsg); 
        return redirect()->route('admin.grn.list');
        // return redirect()->route('admin.purchaseorder.index', ['type'=>'grn']);       
          
    }

    public function saveinventory_bkp(Request $request)
    {
        $request->validate([
            'barcode_no.*' => 'required'
        ],
        [
            // 'barcode_no.required' => 'Please add atleast one scanned box for generating GRN'
            'barcode_no.required' => 'Please add all scanned box for generating GRN or archive other not scanned box'
        ]
        );

        // dd($request->all());

        $params = $request->except('_token');
        
        $data = $this->PurchaseOrderRepository->saveInventory($params);
        // $archive = $this->generateNewPOArchived($params['unique_id']);

        $successMsg = "Stock inventory has been generated with GRN successfully";
        

        if($data){
            Session::flash('message', $successMsg); 
            return redirect()->route('admin.purchaseorder.index', ['type'=>'grn']);
        }else{
            return redirect()->route('admin.purchaseorder.index', ['type'=>'po']);
        } 
          
    }

    private function generateNewPOArchived($unique_id)
    {
        # code...
        $isArchive = false;
        $purchase_orders = PurchaseOrder::where('unique_id',$unique_id)->first();
        $supplier_id = $purchase_orders->supplier_id;
        $address = $purchase_orders->address;
        $state = $purchase_orders->state;
        $city = $purchase_orders->city;
        $country = $purchase_orders->country;
        $pin = $purchase_orders->pin;

        $data = DB::table('purchase_order_archived_boxes')->select('barcode_no','product_id','code_html','code_base64_img')->where('po_uniquie_id',$unique_id)->get();

        $products = DB::table('purchase_order_archived_boxes')->select('product_id',DB::raw('count(*) as total'))->where('po_uniquie_id',$unique_id)->groupBy('product_id')->get();

        // echo '<pre>'; print_r($products); die;
        $new_unique_id = time();
        // echo $new_unique_id;

        /* Add New Purchase Order */
        if(!empty($products)){
            foreach($products as $p){

        
                $product = Product::find($p->product_id);
                $pro_name = $product->name;
                $pro_hsn_code = $product->hsn_code;
                $pro_unit_value = $product->unit_value;
                $pro_unit_type = $product->unit_type;
                $pro_threshold_price = $product->threshold_price;
                $total_price = ($p->total * $pro_threshold_price);
    
                $newEntry = new PurchaseOrder;
                $newEntry->supplier_id = $supplier_id;
                $newEntry->unique_id = $new_unique_id;
                $newEntry->address = $address;
                $newEntry->state = $state;
                $newEntry->city = $city;
                $newEntry->country = $country;
                $newEntry->pin = $pin;
                $newEntry->product_id = $p->product_id;
                $newEntry->product = $pro_name;
                $newEntry->qty = $p->total;
                $newEntry->unit_value = $pro_unit_value;
                $newEntry->unit_type = $pro_unit_type;
                $newEntry->unit_price = $pro_threshold_price;
                $newEntry->total_price = $total_price;
                $newEntry->hsn_code = $pro_hsn_code;
                $newEntry->save();
                $po_id = $newEntry->id;
    
                foreach($data as $d){
                    DB::table('purchase_order_boxes')->insert([
                        'po_id' => $po_id,
                        'po_uniquie_id' => $new_unique_id,
                        'product_id' => $d->product_id,
                        'product_description' => productUnit($d->product_id),
                        'barcode_no' => $d->barcode_no,
                        'code_html' => $d->code_html,
                        'code_base64_img' => $d->code_base64_img
                    ]);
                }
            }
            $isArchive = true;
        }
        

        /* Delete Existing Archived Boxes */
        DB::table('purchase_order_archived_boxes')->where('po_uniquie_id',$unique_id)->delete();
        
        // echo '<pre>'; print_r($data); 
        // die;
        return $isArchive;
    }

    public function viewstocks($unique_id)
    {
        $data = $this->PurchaseOrderRepository->viewStocks($unique_id);
        // dd($data);
        return view('admin.purchaseorder.viewstock', compact('data'));
    }

    public function getProductsSupplier(Request $request)
    {
        $supplier_id = $request->supplier_id;
        $products = DB::table('products')->select('*')->where('supplier_id',$supplier_id)->get();
        return $products;
    }

    // Ajax    
    public function checkScannedboxes(Request $request)
    {
        # code...
        $id = $request->id;
        $data = PurchaseOrderBox::select('barcode_no','is_scanned','scanned_weight_val')->where('purchase_order_id',$id)->where(function($q){
            $q->where('is_scanned', 1)->orWhere('is_bulk_scanned', 1);
        })->get();

        $count_pro_scanned = PurchaseOrderBox::select('product_id')->selectRaw("COUNT(id) AS total_scanned")->where('purchase_order_id',$id)->where(function($q){
            $q->where('is_scanned', 1)->orWhere('is_bulk_scanned', 1);
        })->groupBy('product_id')->get();

        // return $data;
        return response()->json(array('successData'=>$data,'count_pro_scanned'=>$count_pro_scanned));
    }

    public function viewGrn($unique_id)
    {
        # code...
        $data = $products = array();
        $products = DB::table('purchase_orders AS po')
                        ->select('po.*','p.name AS pro_name')
                        ->where('unique_id',$unique_id)
                        ->leftJoin('products AS p', 'p.id','po.product_id')
                        ->get()->toarray();
                       
        if(!empty($products)){
            foreach($products as $p){
                $data = DB::table('purchase_order_boxes AS pob')->select('pob.*')->where('pob.product_id', $p->product_id)->where('pob.po_uniquie_id', $p->unique_id)->orderBy('pob.id', 'desc')->get()->toarray();

                $scanned_box = DB::table('purchase_order_boxes AS pob')->where('pob.is_scanned', 1)->where('pob.product_id', $p->product_id)->where('pob.po_uniquie_id', $p->unique_id)->count();

                $p->boxes = $data;
                $p->scanned_box = $scanned_box;
            }
        }

        // dd($products);
        
        $total_po_price = PurchaseOrder::where('unique_id',$unique_id)->sum('total_price');
        
        return view('admin.purchaseorder.viewgrn', compact('products','data','unique_id','total_po_price'));
    }
    
}
