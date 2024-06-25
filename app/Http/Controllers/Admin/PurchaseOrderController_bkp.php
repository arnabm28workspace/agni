<?php

namespace App\Http\Controllers\Admin;

use App\Interfaces\PurchaseOrderInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderBox;
use App\Models\Product;
use App\Models\Supplier;
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
        $term = !empty($request->term)?$request->term:'';
        $product = !empty($request->product)?$request->product:'';
        $product_name = !empty($request->product_name)?$request->product_name:'';
        
        $data = PurchaseOrder::groupBy('unique_id')
                        ->selectRaw('*, sum(total_price) as amount, sum(qty) AS total_qty,(SELECT COUNT(id) FROM purchase_order_archived_boxes WHERE purchase_order_archived_boxes.po_uniquie_id = purchase_orders.unique_id) AS total_archived_qty , (SELECT GROUP_CONCAT(po2.product_id) FROM purchase_orders AS po2 WHERE po2.unique_id = purchase_orders.unique_id ) AS pro_ids , (SELECT COUNT(id) FROM purchase_order_boxes WHERE purchase_order_boxes.po_uniquie_id = purchase_orders.unique_id AND purchase_order_boxes.is_scanned = 1) AS scanned_boxes , (SELECT SUM(purchase_orders.pcs * purchase_orders.qty)) AS total_pcs ');
                        

        $total = PurchaseOrder::distinct('unique_id');        
        // $total = $total->where('unique_id','LIKE','%'.$term.'%');        

        $status = 1;
        if($type == 'po'){                                    
            $data = $data->where('status', 1);
            $total = $total->where('status', 1);
            $status = 1;
        } else if ($type == 'grn') {            
            $data = $data->where('status', 2);
            $total = $total->where('status', 2);
            $status = 2;
        }

        if(!empty($product)){
            $data = $data->where('product_ids', 'LIKE','%'.$product.'%');
            $total = $total->where('product_ids', 'LIKE','%'.$product.'%');
        }
        $data = $data->orderBy('id','desc')->paginate(20);
        $total = $total->count();

        // dd($data);

        $data = $data->appends([
            'term'=>$term,
            'product'=>$product,
            'product_name'=>$product_name,
            'page'=>$request->page,
            'type'=>$type
        ]);
        
        // echo $total; die;
        // dd($data);
        return view('admin.purchaseorder.index', compact('data','term','product','product_name','total','type'));
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
        foreach($details as $item){
            // dd($item['product_id']);
            $idsArr[] = $item['product_id'];
        }
        // dd($idsArr);
        $product_ids = implode(",",$idsArr);
        // die;

        foreach($details as $item){
            if($item['weight_unit'] == 'kg'){
                $item['weight_value'] = ($item['weight'] * 1000);
            } else {
                $item['weight_value'] = $item['weight'];
            }

            $purchase_orders_data = array(
                'unique_id' => $params['unique_id'],
                'supplier_id' => $params['supplier_id'],                
                'address' => $params['address'],
                'state' => $params['state'],
                'city' => $params['city'],
                'country' => $params['country'],
                'pin' => $params['pin'],
                'product_id' => $item['product_id'],
                'product' => $item['product'],
                'product_ids' => $product_ids,
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
            );
            $po_id = PurchaseOrder::insertGetId($purchase_orders_data);

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
                DB::table('purchase_order_boxes')->insert([
                    'po_id' => $po_id,
                    'po_uniquie_id' => $params['unique_id'],
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

    public function show(Request $request, $unique_id)
    {
        $code_html_arr = array();
        $data = $this->PurchaseOrderRepository->listById($unique_id);
        // dd($data);

        $purchase_order_boxes = DB::table('purchase_order_boxes')->where('po_uniquie_id',$unique_id)->take(1)->get()->toarray();

        $total_po_price = PurchaseOrder::where('unique_id',$unique_id)->sum('total_price');

        if(!empty($purchase_order_boxes)){
            foreach($purchase_order_boxes as $pob){
                $code_html_arr[] = $pob->code_html;
            }
        }
        // die($total_po_price);
        return view('admin.purchaseorder.detail', compact('data','code_html_arr','unique_id','total_po_price'));
    }

    public function barcodes($unique_id)
    {
        $code_html_arr = array();
        $purchase_order_boxes = DB::table('purchase_order_boxes')->select('purchase_order_boxes.*','products.name')->leftJoin('products','products.id','purchase_order_boxes.product_id')->where('po_uniquie_id',$unique_id)->get()->toarray();

        // if(!empty($purchase_order_boxes)){
        //     foreach($purchase_order_boxes as $pob){
        //         $code_html_arr[] = $pob->code_html;
        //     }
        // }

        return view('admin.purchaseorder.barcode', compact('purchase_order_boxes','unique_id'));
    }

    public function edit(Request $request, $unique_id)
    {
        $data = $this->PurchaseOrderRepository->listById($unique_id);
        // dd($data);       
        $suppliers = $this->PurchaseOrderRepository->supplierList();
        $supplier_details = Supplier::find($data[0]->supplier_id);

        $products = DB::table('products')->where('status',1)->orderBy('name','asc')->get();
        return view('admin.purchaseorder.edit', compact('data', 'products', 'supplier_details','unique_id'));
    }

    public function update_old(Request $request)
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
        
        $findPo = PurchaseOrder::where('unique_id', $params['unique_id'])->delete();
        $findpoboxes = DB::table('purchase_order_boxes')->where('po_uniquie_id',$params['unique_id'])->delete();
        $findarchivedboxes = DB::table('purchase_order_archived_boxes')->where('po_uniquie_id',$params['unique_id'])->delete();

        foreach($details as $item){
            if($item['weight_unit'] == 'kg'){
                $item['weight_value'] = ($item['weight'] * 1000);
            } else {
                $item['weight_value'] = $item['weight'];
            }

            $purchase_orders_data = array(
                'unique_id' => $params['unique_id'],
                'supplier_id' => $params['supplier_id'],                
                'address' => $params['address'],
                'state' => $params['state'],
                'city' => $params['city'],
                'country' => $params['country'],
                'pin' => $params['pin'],
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
            );
            $po_id = PurchaseOrder::insertGetId($purchase_orders_data);

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
                DB::table('purchase_order_boxes')->insert([
                    'po_id' => $po_id,
                    'po_uniquie_id' => $params['unique_id'],
                    'product_id' => $item['product_id'],
                    'pcs' => $item['pcs'],
                    'barcode_no' => $barcode_no,
                    'code_html' => $code_html,
                    'code_base64_img' => $code_base64_img,
                    'po_weight_val' => $item['weight_value']
                ]);
            }

        }

        Session::flash('message', 'Purchase order updated successfully');
        return redirect()->route('admin.purchaseorder.index', ['type'=>'po']);
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
        
        foreach($details as $item){
            if($item['weight_unit'] == 'kg'){
                $item['weight_value'] = ($item['weight'] * 1000);
            } else {
                $item['weight_value'] = $item['weight'];
            }
            PurchaseOrder::where('unique_id',$params['unique_id'])->where('product_id',$item['product_id'])->update([
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
                        DB::table('purchase_order_boxes')->insert([
                            'po_id' => $item['po_id'],
                            'po_uniquie_id' => $params['unique_id'],
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
                    $old_rest_box = DB::table('purchase_order_boxes')->select('barcode_no')->where('po_uniquie_id',$params['unique_id'])->where('product_id',$item['product_id'])->orderBy('id','desc')->take($rest)->delete();
                    // echo '<pre>'; print_r($old_rest_box);

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



    public function bulkSuspend(Request $request)
    {
        // die('h');
        // print_r($request->suspend_check);
        $data = $this->PurchaseOrderRepository->bulkSuspend($request->suspend_check);  

        if($data){
            return redirect()->route('admin.purchaseorder.index', ['type'=>'po']);
        }else{
            return redirect()->route('admin.purchaseorder.index', ['type'=>'po']);
        }
    }

    
    public function showboxes(Request $request,$unique_id)
    {
        $search = !empty($request->search)?$request->search:'';
        
        $data = PurchaseOrderBox::with('purchase_orders')->where('po_uniquie_id',$unique_id);  
        $totalData = PurchaseOrderBox::with('purchase_orders')->where('po_uniquie_id',$unique_id); 
        if(!empty($search)){
            $data = $data->where(function($q) use ($search){
                $q->where('product_id', $search)->orWhereHas('product', function ($searchproduct) use ($search) {
                    $searchproduct->where('name', 'LIKE','%'.$search.'%');
                })->orWhereHas('purchase_orders', function ($searchbarcode) use ($search) {
                    $searchbarcode->where('barcode_no', 'LIKE','%'.$search.'%');
                });
            });
            $totalData = $totalData->where(function($q) use ($search){
                $q->where('product_id', $search)->orWhereHas('product', function ($searchproduct) use ($search) {
                    $searchproduct->where('name', 'LIKE','%'.$search.'%');
                })->orWhereHas('purchase_orders', function ($searchbarcode) use ($search) {
                    $searchbarcode->where('barcode_no', 'LIKE','%'.$search.'%');
                });
            });
            
        }
        $data = $data->orderBy('barcode_no','asc')->get()->sortBy('product_id')->groupBy('product.id');
        $totalData = $totalData->count();
        // dd($data);
        
        return view('admin.purchaseorder.showboxes', compact('data','totalData','unique_id','search'));
    }

    public function grn(Request $request,$unique_id)
    {
        # code...
        $search = !empty($request->search)?$request->search:'';

        $data = PurchaseOrderBox::with('purchase_orders')->where('po_uniquie_id',$unique_id);        
        if(!empty($search)){
            $data = $data->where(function($q) use ($search){
                $q->where('product_id', $search)->orWhereHas('product', function ($searchproduct) use ($search) {
                    $searchproduct->where('name', 'LIKE','%'.$search.'%');
                })->orWhereHas('purchase_orders', function ($searchbarcode) use ($search) {
                    $searchbarcode->where('barcode_no', 'LIKE','%'.$search.'%');
                });
            });
        }
        $data = $data->orderBy('barcode_no','asc')->get()->sortBy('product_id')->groupBy('product.id');

        // dd($data);

        $total_po_price = PurchaseOrder::where('unique_id',$unique_id)->sum('total_price');

        $total_checked = PurchaseOrderBox::where('po_uniquie_id',$unique_id)->where('is_scanned', 1)->count();

        // dd($total_checked);

        return view('admin.purchaseorder.grn', compact('data','unique_id','total_po_price','search','total_checked'));
    }

    public function grn_old($unique_id)
    {
        $data = $this->PurchaseOrderRepository->showProductBoxes($unique_id);
        // dd($data);
        $total_po_price = PurchaseOrder::where('unique_id',$unique_id)->sum('total_price');
        
        return view('admin.purchaseorder.grn', compact('data','unique_id','total_po_price'));
    }

    public function addbox($unique_id,$product_id)
    {
        $data = $this->PurchaseOrderRepository->addBox($unique_id,$product_id);

        if($data){
            Session::flash('message', 'New carton added suceesfully'); 
            return redirect()->route('admin.purchaseorder.grn', $unique_id);
        }else{
            return redirect()->route('admin.purchaseorder.grn', $unique_id);
        }
    }

    public function deletebox($unique_id,$product_id,$barcode_no)
    {
        $data = $this->PurchaseOrderRepository->deleteBox($unique_id,$product_id,$barcode_no);

        if($data){
            Session::flash('message', 'Box '.$barcode_no.' is deleted suceesfully'); 
            return redirect()->route('admin.purchaseorder.grn', $unique_id);
        }else{
            return redirect()->route('admin.purchaseorder.grn', $unique_id);
        }
    }

    public function archiveBox($unique_id,$product_id,$barcode_no)
    {
        # remove box and archive box to another place ...
        $data = $this->PurchaseOrderRepository->archiveBox($unique_id,$product_id,$barcode_no);

        if($data){
            Session::flash('message', 'Carton '.$barcode_no.' is archived suceesfully'); 
            return redirect()->route('admin.purchaseorder.grn', $unique_id);
        }else{
            return redirect()->route('admin.purchaseorder.grn', $unique_id);
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
        $request->validate([
            'barcode_no.*' => 'required'
        ],
        [
            // 'barcode_no.required' => 'Please add atleast one scanned box for generating GRN'
            'barcode_no.required' => 'Please add all scanned box for generating GRN or archive other not scanned box'
        ]
        );

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
        $po_uniquie_id = $request->uniquie_id;
        $data = DB::table('purchase_order_boxes')->select('barcode_no','is_scanned','scanned_weight_val')->where('po_uniquie_id',$po_uniquie_id)->where('is_scanned', 1)->get();

        return $data;
        // return response()->json(array('successData'=>$data));
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
