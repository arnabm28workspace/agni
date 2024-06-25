<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\OrderInterface;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use Illuminate\Support\Carbon;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct(OrderInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    
    public function view($userId,$storeId): JsonResponse
    {

        $order = Order::where('user_id',$userId)->where('store_id',$storeId)->orderBy('id','desc')->take(3)->get();
        // $order = $this->orderRepository->listByuserId($userId);

        return response()->json(['error'=>false, 'resp'=>'Order data fetched successfully','data'=>$order]);
    }
    

    public function placeorder(Request $request): JsonResponse
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'integer', 'min:1', 'exists:users,id'],
            'store_id' => ['required', 'integer', 'min:1', 'exists:stores,id'],
            'comment' => ['string'],
            'order_location' => ['string','nullable'],
            'order_lat' => ['string','nullable'],
            'order_lng' => ['string','nullable'],
            'attendance_id' => ['nullable','exists:user_attendances,id'],
            'is_gst' => ['required','string', 'in:0,1']
        ]);
        $params = $request->except('_token');
        
        if (!$validator->fails()) {

            if(!in_array($params['user_id'],[1,2])){
                if(empty($request->order_lat)){
                    return response()->json(['status'=>400,'message'=>"Please add latitude"], 400);
                }
                if(empty($request->order_lng)){
                    return response()->json(['status'=>400,'message'=>"Please add longitude"], 400);
                }
                if(empty($request->attendance_id)){
                    return response()->json(['status'=>400,'message'=>"Please add attendance id"], 400);
                }

                $checkattendance = DB::table('user_attendances')->find($params['attendance_id']);

                if($checkattendance->user_id != $params['user_id']){
                    return response()->json(
                        [
                            'error' => true,
                            'message' => "This is not you attendacne id ",
                            'data' => (object) []
                        ],
                        200
                    );
                }
                if($checkattendance->start_date != date('Y-m-d')){
                    return response()->json(
                        [
                            'error' => true,
                            'message' => "This is not today's attendance id",
                            'data' => (object) []
                        ],
                        200
                    );
                }
            }            
            $checkCart = Cart::where('user_id', $params['user_id'])->first();
            if(empty($checkCart)){
                return response()->json(
                    [
                        'error' => true,
                        'message' => "No items found in cart",
                        'data' => (object) []
                    ],
                    200
                );
            }
            if(!in_array($params['user_id'], [1,2])){
                $attendance_id = $params['attendance_id'];
                $latitude = $params['order_lat'];
                $longitude = $params['order_lng'];
                updatelocationattendance($attendance_id,$latitude,$longitude,$params['store_id']);
            }            
            return response()->json(
                [
                    'data' => $this->orderRepository->placeOrder($params)
                ],
                Response::HTTP_CREATED
            );
        } else {
            return response()->json(['status' => 400, 'message' => $validator->errors()->first()]);
        }
        
        
    }


       
}
