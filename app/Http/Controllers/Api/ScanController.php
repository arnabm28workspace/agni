<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\StockBox;
use App\Models\Packingslip;
use App\Models\PackingslipBox;

class ScanController extends Controller
{
    //
    /*public function box(Request $request): JsonResponse
    {
        
        $validator = Validator::make($request->all(), [
            'barcode_no' => ['required'],
            'scanned_weight_val' => ['required']
        ]);

        $params = $request->except('_token');

        if (!$validator->fails()) {

            $barcode_no = $params['barcode_no'];
            $scanned_weight_val = $params['scanned_weight_val'];

            $checkBarcode = DB::table('purchase_order_boxes')->where('barcode_no',$barcode_no)->first();

            if(!empty($checkBarcode)){
                if(empty($checkBarcode->is_scanned)){
                    $po_weight_val = $checkBarcode->po_weight_val;
                    $approxUpWeight = ($po_weight_val + 50);
                    $approxDownWeight = ($po_weight_val - 50);
                    
                    if (($scanned_weight_val <= $approxUpWeight && $scanned_weight_val >= $approxDownWeight) ) {
                        // die('Ok');
                        DB::table('purchase_order_boxes')->where('barcode_no',$barcode_no)->update(['is_scanned'=>1, 'scanned_weight_val' => $scanned_weight_val, 'updated_at'=>date('Y-m-d H:i:s')]);

                        return response()->json(
                            [
                                'error' => false,
                                'status' => 200,
                                'message' => 'Scanned successfully',
                                'data' => (object)[]
                            ]
                        );
                    } else {
                        // die('Mismatched');
                        return response()->json(
                            [
                                'error' => true,
                                'status' => 200,
                                'message' => 'Mismatched weight.',
                                'data' => (object)[]
                            ]
                        );
                    }
                }else{
                    return response()->json(
                        [
                            'error' => true,
                            'status' => 200,
                            'message' => 'Already scanned',
                            'data' => (object)[]
                        ]
                    );
                }
            }else{
                return response()->json(
                    [
                        'error' => true,
                        'status' => 200,
                        'message' => 'No barcode found',
                        'data' => (object)[]
                    ]
                );
            }
            
        } else {
            return response()->json(
                [
                    'status' => 400, 
                    'message' => $validator->errors()->first()
                ]
            );
        }
        
    }*/

    public function box(Request $request)
    {
        # without weight value...
        $validator = Validator::make($request->all(), [
            'barcode_no' => ['required']
        ]);

        $params = $request->except('_token');

        if (!$validator->fails()) {

            $barcode_no = $params['barcode_no'];

            $checkBarcode = DB::table('purchase_order_boxes')->where('barcode_no',$barcode_no)->first();

            if(!empty($checkBarcode)){
                $purchase_order_id = $checkBarcode->purchase_order_id;
                $checkPO = DB::table('purchase_orders')->find($purchase_order_id);
                // dd($purchase_order_id);
                if($checkPO->goods_in_type == 'bulk'){
                    return response()->json(
                        [
                            'error' => true,
                            'status' => 200,
                            'message' => 'This barcode is under bulk goods in',
                            'data' => (object)[]
                        ]
                    );
                }
                if(empty($checkBarcode->is_scanned)){
                    $po_weight_val = $checkBarcode->po_weight_val;
                      
                    DB::table('purchase_order_boxes')->where('barcode_no',$barcode_no)->update(['is_scanned'=>1, 'scanned_weight_val' => $po_weight_val, 'updated_at'=>date('Y-m-d H:i:s')]);

                    return response()->json(
                        [
                            'error' => false,
                            'status' => 200,
                            'message' => 'Scanned successfully',
                            'data' => (object)[]
                        ]
                    );
                    
                }else{
                    return response()->json(
                        [
                            'error' => true,
                            'status' => 200,
                            'message' => 'Already scanned',
                            'data' => (object)[]
                        ]
                    );
                }
            }else{
                return response()->json(
                    [
                        'error' => true,
                        'status' => 200,
                        'message' => 'No barcode found',
                        'data' => (object)[]
                    ]
                );
            }
            
        } else {
            return response()->json(
                [
                    'status' => 400, 
                    'message' => $validator->errors()->first()
                ]
            );
        }
    }

    /*public function stockout(Request $request): JsonResponse
    {
        
        $validator = Validator::make($request->all(), [
            'barcode_no' => ['required'],
            'stock_out_weight_val' => ['required']
        ]);

        $params = $request->except('_token');

        if (!$validator->fails()) {

            $barcode_no = $params['barcode_no'];
            $stock_out_weight_val = $params['stock_out_weight_val'];

            $checkBarcode = DB::table('stock_boxes')->where('barcode_no',$barcode_no)->first();

            if(!empty($checkBarcode)){
                if(!empty($checkBarcode->is_scanned) && empty($checkBarcode->scan_no)){

                    $stock_in_weight_val = $checkBarcode->stock_in_weight_val;
                    $approxUpWeight = ($stock_in_weight_val + 50);
                    $approxDownWeight = ($stock_in_weight_val - 50);

                    if (($stock_out_weight_val <= $approxUpWeight && $stock_out_weight_val >= $approxDownWeight) ) {

                        DB::table('stock_boxes')->where('barcode_no',$barcode_no)->update(['scan_no'=>$barcode_no, 'stock_out_weight_val' => $stock_out_weight_val, 'updated_at'=>date('Y-m-d H:i:s')]);

                        DB::table('packing_slip_boxes')->where('barcode_no',$barcode_no)->update(['is_disbursed' => 1]);

                        return response()->json(
                            [
                                'error' => false,
                                'status' => 200,
                                'message' => 'Scanned successfully',
                                'data' => (object)[]
                            ]
                        );

                    } else {
                        return response()->json(
                            [
                                'error' => true,
                                'status' => 200,
                                'message' => 'Mismatched weight.',
                                'data' => (object)[]
                            ]
                        );
                    }

                }else{
                    return response()->json(
                        [
                            'error' => true,
                            'status' => 200,
                            'message' => 'Not released from inventory',
                            'data' => (object)[]
                        ]
                    );
                }
            }else{
                return response()->json(
                    [
                        'error' => true,
                        'status' => 200,
                        'message' => 'No barcode found',
                        'data' => (object)[]
                    ]
                );
            }
            
        } else {
            return response()->json(
                [
                    'status' => 400, 
                    'message' => $validator->errors()->first()
                ]
            );
        }
        
    }*/

    public function stockout(Request $request)
    {
        # code...
        $validator = Validator::make($request->all(), [
            'slip_no' => 'required|exists:packing_slip,slip_no',
            'product_id' => 'required|exists:products,id',
            'barcode_no' => 'required|exists:stock_boxes,barcode_no',
            // 'stock_out_weight_val' => 'required'
        ]);

        $params = $request->except('_token');

        if(!$validator->fails()){
            $exist = StockBox::where('barcode_no',$params['barcode_no'])->first();
            if(empty($exist->is_scanned)){
                if($exist->product_id == $params['product_id']){
                    $packing_slip = Packingslip::where('slip_no',$params['slip_no'])->where('product_id',$params['product_id'])->first();
                    $scan_product_quantity = $packing_slip->quantity;
                    
                    $check_done = StockBox::where('slip_no',$params['slip_no'])->where('product_id',$params['product_id'])->count();

                    $stock_in_weight_val = $exist->stock_in_weight_val;

                    if($check_done == $scan_product_quantity){
                        return Response::json(
                            [
                                'error' => true,
                                'message' => "For this product ".$scan_product_quantity." barcodes scanning completed ",
                                'data' => (object) []
                            ],200
                        );
                    } else {
                        StockBox::where('barcode_no',$params['barcode_no'])->update([
                            'scan_no'=>$params['barcode_no'], 
                            'is_scanned'=>1,
                            'stock_out_weight_val' => $stock_in_weight_val,
                            // 'stock_out_weight_val' => $params['stock_out_weight_val'],
                            'slip_no' => $params['slip_no'],
                            'updated_at'=>date('Y-m-d H:i:s')
                        ]);
                        $count_product_scanned = StockBox::where('slip_no',$params['slip_no'])->where('product_id',$params['product_id'])->where('is_scanned',1)->count();
                        return Response::json(['error' => false, 'message' => "Scanned successfully", 'data' => array(
                            'required_product_scan' => $scan_product_quantity,
                            'count_product_scanned' => $count_product_scanned,
                            'else_product_scan' => ($scan_product_quantity - $count_product_scanned)
                        ) ],200);
                    }
                } else {
                    return Response::json(
                        [
                            'error' => true,
                            'message' => "Product mismatched",
                            'data' => (object) []
                        ],200
                    );
                }
                

                
            } else {
                return Response::json(
                    [
                        'error' => true,
                        'message' => "Already scanned",
                        'data' => (object) []
                    ],200
                );
            }
        } else {
            return Response::json(
                [
                    'error' => true,
                    'message' => $validator->errors()->first()
                ],400
            );
        }
    }

    public function ps_list(Request $request): JsonResponse
    {
        # not goods out ps list...
        $data = Packingslip::select('id','order_id','product_id','slip_no','quantity','is_disbursed')->with([
            'order' => function($q){
                $q->select('id','order_no','store_id')->with('stores:id,store_name,bussiness_name');
            }
        ])->with('product:id,name')->where('is_disbursed', 0)->get();

        return response()->json([
            'error' => false,
            'status' => 200,
            'message' => 'Disbusrseable ps product list',
            'data' => array(
                'count_list' => count($data),
                'list' => $data
            )
        ]);
    }
}
