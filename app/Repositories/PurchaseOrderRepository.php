<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Interfaces\PurchaseOrderInterface;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Category;
use App\Models\PurchaseOrderImage;
use App\Models\SubCategory;
use App\Traits\UploadAble;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderRepository implements PurchaseOrderInterface
{
    use UploadAble;

    public function listAll()
    {
        return PurchaseOrder::groupBy('unique_id')
                ->selectRaw('*, sum(total_price) as amount')
                ->with('supplier')     
                ->orderBy('id','desc')       
                ->get();
    }
    
    public function supplierList()
    {
        return Supplier::all();
    }
    
    public function productList()
    {
        return Product::all();
    }

    public function getSearchPurchaseOrders(string $term)
    {
        $data =  PurchaseOrder::where('unique_id', 'LIKE', '%' . $term . '%')
                    ->orWhere('product', 'LIKE', '%' . $term . '%')
                    ->orWhere('address', 'LIKE', '%' . $term . '%')
                    // ->orWhere('total_price', 'LIKE', '%' . $term . '%')
                    ->selectRaw('*, sum(total_price) as amount')
                    ->with('supplier')
                    ->get();
        // dd($data);
        if ($data[0]->id) {
            # code...
            return $data;
        } else {
            return [];
        }
    }

    public function listById($unique_id)
    {
        $orders = PurchaseOrder::where('unique_id',$unique_id)                        
                        ->with('supplier:id,name,mobile,email,billing_address,billing_landmark,billing_state,billing_city,billing_pin,billing_country')
                        ->get();
        
        return $orders;
    }

    public function create(array $data)
    {
        // dd($data);
        DB::beginTransaction();

        try {
            // dd($data);
            $collectedData = collect($data);

            // dd($collectedData);
            
            if (count($collectedData['product'])) {
                for ($i=0; $i < count($collectedData['product']); $i++) { 
                    $newEntry = new PurchaseOrder;
                    $newEntry->supplier_id = $collectedData['supplier_id'];
                    $newEntry->unique_id = $collectedData['unique_id'];
                    $newEntry->address = $collectedData['address'];
                    $newEntry->state = $collectedData['state'];
                    $newEntry->city = $collectedData['city'];
                    $newEntry->country = $collectedData['country'];
                    $newEntry->pin = $collectedData['pin'];
                    $newEntry->product_id = $collectedData['product_id'][$i];
                    $newEntry->product = $collectedData['product'][$i];
                    $newEntry->qty = $collectedData['qty'][$i];
                    // $newEntry->unit_value = $collectedData['unit_value'][$i];
                    // $newEntry->unit_type = 'pieces';
                    $newEntry->pcs = $collectedData['pcs'][$i];
                    $newEntry->unit_price = $collectedData['price_per_carton'][$i];
                    $newEntry->piece_price = $collectedData['piece_price'][$i];
                    $newEntry->weight = $collectedData['weight'][$i];
                    $newEntry->weight_unit = $collectedData['weight_unit'][$i];
                    if($collectedData['weight_unit'][$i] == 'kg'){
                        $newEntry->weight_value = ($collectedData['weight'][$i] * 1000);
                    } else {
                        $newEntry->weight_value = $collectedData['weight'][$i];
                    }
                    
                    $newEntry->total_price = $collectedData['total_price'][$i];
                    $newEntry->hsn_code = $collectedData['hsn_code'][$i];
                    // echo $collectedData['qty'][$i]; echo '<br>';
                    $newEntry->save();
                    $po_id = $newEntry->id;

                    /* Update product threshold and sell price */

                    $updateProductSellPrice = updateProductSellPrice($collectedData['price_per_carton'][$i],$collectedData['piece_price'][$i],$collectedData['product_id'][$i]);

                    Product::where('id',$collectedData['product_id'][$i])->update([                        
                        'hsn_code' => $collectedData['hsn_code'][$i],
                        // 'pcs' => $collectedData['pcs'][$i]
                    ]);


                    for($j=0;$j < ($collectedData['qty'][$i]); $j++){
                        $barcodeGen = barcodeGen();
                        $barcode_no = $barcodeGen['barcode_no'];
                        $code_html = $barcodeGen['code_html'];
                        $code_base64_img = $barcodeGen['code_base64_img'];
                        DB::table('purchase_order_boxes')->insert([
                            'po_id'=>$po_id,
                            'po_uniquie_id'=>$newEntry->unique_id,
                            'product_id'=>$collectedData['product_id'][$i],
                            'pcs'=>$collectedData['pcs'][$i],
                            'barcode_no'=> $barcode_no,
                            'code_html'=>$code_html,
                            'code_base64_img'=>$code_base64_img,
                            'po_weight_val' => $newEntry->weight_value
                        ]);
                    }
                }
            }

            // die;

            DB::commit();
            return $newEntry;
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
        }
    }

    public function update(array $data)
    {
        // dd($data);
        DB::beginTransaction();

        
        try {
            // dd($data);
            $collectedData = collect($data);
            $findPo = PurchaseOrder::where('unique_id', $collectedData['unique_id'])->delete();
            $findpoboxes = DB::table('purchase_order_boxes')->where('po_uniquie_id',$collectedData['unique_id'])->delete();
            $findarchivedboxes = DB::table('purchase_order_archived_boxes')->where('po_uniquie_id',$collectedData['unique_id'])->delete();
            // dd('$findPo', $findPo);
            
            if (count($collectedData['product'])) {
                for ($i=0; $i < count($collectedData['product']); $i++) { 
                    $newEntry = new PurchaseOrder;
                    $newEntry->supplier_id = $collectedData['supplier_id'];
                    $newEntry->unique_id = $collectedData['unique_id'];
                    $newEntry->address = $collectedData['address'];
                    $newEntry->state = $collectedData['state'];
                    $newEntry->city = $collectedData['city'];
                    $newEntry->country = $collectedData['country'];
                    $newEntry->pin = $collectedData['pin'];
                    $newEntry->product_id = $collectedData['product_id'][$i];
                    $newEntry->product = $collectedData['product'][$i];
                    $newEntry->qty = $collectedData['qty'][$i];
                    // $newEntry->unit_value = $collectedData['unit_value'][$i];
                    // $newEntry->unit_type = 'pieces';
                    $newEntry->pcs = $collectedData['pcs'][$i];
                    $newEntry->unit_price = $collectedData['price_per_carton'][$i];
                    $newEntry->piece_price = $collectedData['piece_price'][$i];
                    $newEntry->weight = $collectedData['weight'][$i];
                    $newEntry->weight_unit = $collectedData['weight_unit'][$i];
                    if($collectedData['weight_unit'][$i] == 'kg'){
                        $newEntry->weight_value = ($collectedData['weight'][$i] * 1000);
                    } else {
                        $newEntry->weight_value = $collectedData['weight'][$i];
                    }
                    
                    $newEntry->total_price = $collectedData['total_price'][$i];
                    $newEntry->hsn_code = $collectedData['hsn_code'][$i];
                    // echo $collectedData['qty'][$i]; echo '<br>';
                    $newEntry->save();
                    $po_id = $newEntry->id;

                    /* Update product threshold and sell price */

                    $updateProductSellPrice = updateProductSellPrice($collectedData['price_per_carton'][$i],$collectedData['piece_price'][$i],$collectedData['product_id'][$i]);

                    Product::where('id',$collectedData['product_id'][$i])->update([                        
                        'hsn_code' => $collectedData['hsn_code'][$i],
                        // 'pcs' => $collectedData['pcs'][$i]
                    ]);


                    for($j=0;$j < ($collectedData['qty'][$i]); $j++){
                        $barcodeGen = barcodeGen();
                        $barcode_no = $barcodeGen['barcode_no'];
                        $code_html = $barcodeGen['code_html'];
                        $code_base64_img = $barcodeGen['code_base64_img'];
                        DB::table('purchase_order_boxes')->insert([
                            'po_id'=>$po_id,
                            'po_uniquie_id'=>$newEntry->unique_id,
                            'product_id'=>$collectedData['product_id'][$i],
                            'pcs'=>$collectedData['pcs'][$i],
                            'barcode_no'=> $barcode_no,
                            'code_html'=>$code_html,
                            'code_base64_img'=>$code_base64_img,
                            'po_weight_val' => $newEntry->weight_value
                        ]);
                    }                    
                }
            }

            DB::commit();
            return $newEntry;
        } catch (\Throwable $th) {
            throw $th;
            DB::rollback();
        }
    }

    public function toggle($id)
    {
        $updatedEntry = PurchaseOrder::findOrFail($id);

        $status = ($updatedEntry->status == 1) ? 0 : 1;
        $updatedEntry->status = $status;
        $updatedEntry->save();

        return $updatedEntry;
    }

    public function delete($id)
    {
        PurchaseOrder::destroy($id);
    }

    public function bulkSuspend(array $array)
    {
        // PurchaseOrder::whereIn('id', $array)->update(['status' => 0]);
        return true;
    }

    

    public function po_product_list($unique_id)
    {
        $data = DB::table('purchase_orders AS po')->select('p.id','p.name')->leftJoin('products AS p', 'p.id','po.product_id')->where('po.unique_id',$unique_id)->get();
        return $data;
    }

    public function showboxes($unique_id)
    {        
        $data = DB::table('purchase_order_boxes AS pob')->select('pob.*','p.name AS pro_name')->leftJoin('products AS p', 'p.id','pob.product_id')->where('pob.po_uniquie_id',$unique_id)->orderBy('pob.id', 'desc')->get();
        

        return $data;
    }

    public function saveInventory(array $array)
    {       
        $grn_no = getRandString(16);
        $quantity = $array['quantity'];
        $barcode_no_arr = $array['barcode_no'];
        $pcs_arr = $array['pcs'];
        // dd($array);

        $id = DB::table('stock')->insertGetId([
            'po_unique_id' => $array['unique_id'],
            'grn_no' => $grn_no
        ]);

        if(!empty($quantity)){
            foreach($quantity as $key => $value){
                DB::table('stock_products')->insert([
                    'stock_id' => $id,
                    'product_id' => $key,
                    'quantity' => $value,
                    'product_description' => ''
                ]);
            }
        }

        for($i=0; $i < count($barcode_no_arr); $i++){
            $product_id = getProductIdFromBarcode($barcode_no_arr[$i]);
            $getBarcodeDetails = getBarcodeDetails($barcode_no_arr[$i]);
            $code_html = $getBarcodeDetails['code_html'];
            $code_base64_img = $getBarcodeDetails['code_base64_img'];
            $stock_in_weight_val = $getBarcodeDetails['scanned_weight_val'];
            DB::table('stock_boxes')->insert([
                'stock_id' => $id,
                'product_id' => $product_id,
                'pcs' => $pcs_arr[$i],
                'barcode_no' => $barcode_no_arr[$i],
                'code_html'=>$code_html,
                'code_base64_img'=>$code_base64_img,
                'stock_in_weight_val' => $stock_in_weight_val
            ]);
        }

        DB::table('purchase_orders')->where('unique_id',$array['unique_id'])->update(['status'=>2]);

        /* Entry in journal as debit */

        $purchase_orders_amount = DB::table('purchase_orders')->selectRaw('sum(total_price) as amount,supplier_id')->where('unique_id', $array['unique_id'])->first();

        $transaction_amount = $purchase_orders_amount->amount;
        $supplier_id = $purchase_orders_amount->supplier_id;

        /* Supplier Ledger Entry */
        DB::table('ledger')->insert([
            'user_type' => 'supplier',
            'supplier_id' => $supplier_id,
            'transaction_id' => $grn_no,
            'transaction_amount' => $transaction_amount,
            'entry_date' => date('Y-m-d'),
            'is_credit' => 1,'purpose' => 'goods_received_note',
            'purpose_description' => 'Goods Received Note'
        ]);


        /* changelogentry */
        changelogentry(Auth::user()->id,'grn',json_encode($array));

        /* Journal Entry */

        // DB::table('journal')->insert([
        //     'transaction_amount' => $transaction_amount,
        //     'is_debit' => 1,
        //     'purpose' => 'purchase_order_receives',
        //     'purpose_description' => 'Purchase Order Receives',
        //     'purpose_id' => $array['unique_id'],
        //     'entry_date' => date('Y-m-d')
        // ]);
        return true;
        
    }

    
    public function showProductBoxes($unique_id)
    {
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

        
        return $products;
    }

    public function addBox($unique_id,$product_id)
    {
        $po = PurchaseOrder::where('unique_id',$unique_id)->where('product_id',$product_id)->first();
        $qty = $po->qty;
        $qty = $qty+1;

        /* Addition of total amount */

        $unit_price = $po->unit_price;
        $total_price = $po->total_price;
        // echo $unit_price; echo '<br/>';
        $new_total_price = ($total_price + $unit_price);
        // echo $new_total_price; exit;


        // echo $qty; exit;
        $barcodeGen = barcodeGen();
        $barcode_no = $barcodeGen['barcode_no'];
        $code_html = $barcodeGen['code_html'];
        $code_base64_img = $barcodeGen['code_base64_img'];

        PurchaseOrder::where('id', $po->id)->update(['qty' => $qty , 'total_price' => $new_total_price]);
        DB::table('purchase_order_boxes')->insert([
            'po_id'=>$po->id,
            'po_uniquie_id'=>$unique_id,
            'product_id'=>$product_id,
            'barcode_no'=> $barcode_no,
            'code_html'=>$code_html,
            'code_base64_img'=>$code_base64_img,
            'product_description' => '',
            'is_new' => 1
        ]);

        return true;
        
    }

    public function deleteBox($unique_id,$product_id,$barcode_no)
    {
        $po = PurchaseOrder::where('unique_id',$unique_id)->where('product_id',$product_id)->first();
        $qty = $po->qty;
        $qty = $qty-1;
        // echo $qty; exit;
        PurchaseOrder::where('id', $po->id)->update(['qty' => $qty]);
        DB::table('purchase_order_boxes')->where('barcode_no',$barcode_no)->delete();

        return true;
    }

    public function archiveBox($unique_id,$product_id,$barcode_no)
    {
        $po = PurchaseOrder::where('unique_id',$unique_id)->where('product_id',$product_id)->first();
        $qty = $po->qty;
        $qty = $qty-1;

        /* Substraction from total amount */

        $unit_price = $po->unit_price;
        $total_price = $po->total_price;
        $new_total_price = ($total_price - $unit_price);

        // echo $qty; exit;
        PurchaseOrder::where('id', $po->id)->update(['qty' => $qty , 'total_price' => $new_total_price]);
        $purchase_order_boxes = DB::table('purchase_order_boxes')->where('barcode_no',$barcode_no)->first();
        $code_html = $purchase_order_boxes->code_html;
        $code_base64_img = $purchase_order_boxes->code_base64_img;
        $po_weight_val = $purchase_order_boxes->po_weight_val;
        $pcs = $purchase_order_boxes->pcs;
        DB::table('purchase_order_boxes')->where('barcode_no',$barcode_no)->delete();
        DB::table('purchase_order_archived_boxes')->insert([
            'barcode_no' => $barcode_no,
            'code_html' => $code_html,
            'code_base64_img' => $code_base64_img,
            'po_id' => $po->id,
            'po_uniquie_id' => $unique_id,
            'product_id' => $product_id,
            'po_weight_val' => $po_weight_val,
            'pcs' => $pcs
        ]);
        return true;
    }

    public function viewStocks($unique_id)
    {
        $stock = DB::table('stock')->where('po_unique_id',$unique_id)->first();
        $stock_id = $stock->id;
        $stock_products = DB::table('stock_products AS sp')->select('sp.*','p.name AS pro_name')->leftJoin('products AS p', 'p.id','sp.product_id')->where('sp.stock_id',$stock_id)->get();
        $stock_boxes = DB::table('stock_boxes AS sb')->select('sb.*','p.name AS pro_name')->leftJoin('products AS p', 'p.id','sb.product_id')->where('sb.stock_id',$stock_id)->get();

        $stock->stock_products = $stock_products;
        $stock->stock_boxes = $stock_boxes;

        return $stock;
    }

    public function productStock($product_id)
    {
        if(empty($product_id)){

            /* Show all products stock count */

            $data = DB::table('products AS p')->select('p.id','p.name')->selectRaw("(SELECT COUNT(stock_boxes.product_id) FROM stock_boxes WHERE stock_boxes.product_id = p.id) AS count_pro")->get();
        }else{

            /* Show stock boxes of each product */

            $data = DB::table('stock_boxes AS sb')->select('sb.*','s.po_unique_id','s.grn_no')->leftJoin('stock AS s', 's.id', 'sb.stock_id')->where('sb.product_id', $product_id)->get();
        }
        

        // dd($data);
        return $data;
    }

}
