<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\StoreInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\PaymentCollection;
use App\Models\Store;
use App\Models\StoreNote;

class StoreController extends Controller
{
    public function __construct(StoreInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }
    /**
     * This method is for show store list
     *
     */

    public function list(Request $request): JsonResponse
    {
        $search = !empty($request->search)?$request->search:'';



        $data = Store::select('id','store_name','bussiness_name','email','contact','whatsapp','status','is_approved','shipping_address AS address');

        if(!empty($search)){
            $data = $data->where('store_name', 'LIKE', '%'.$search.'%')->orWhere('bussiness_name', 'LIKE', '%'.$search.'%')->orWhere('contact', 'LIKE', '%'.$search.'%');
        }
        
        $data = $data->where('status', 1)->orderBy('store_name','asc')->get();

        return response()->json(['error'=>false,'message'=>"Store List", 'data'=> array('store'=>$data) ],200);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            // "created_from" => "required|string|in:staff",   
            "created_by" => "required|numeric|exists:users,id",   
            // "store_name" => "required|string|max:255",            
            "whatsapp"=>"required|unique:stores|max:10",
            // "email" => "nullable|string",
            // "gst_number" => "required",
            // "shipping_address" => "required|string",
            // "shipping_landmark" => "required|string",
            // "shipping_state" => "required|string",
            // "shipping_city" => "required|string",
            // "shipping_pin" => "required|string",
            // "shipping_country" => "required|string",
            // "billing_address" => "required|string",
            // "billing_landmark" => "required|string",
            // "billing_state" => "required|string",
            // "billing_city" => "required|string",
            // "billing_pin" => "required|string",
            // "billing_country" => "required|string",
            // "gst_file" =>"nullable|mimes:jpg,jpeg,png,svg,gif|max:10000000"
        ]);
        
        $params = $request->except('_token');
        
        if (!$validator->fails()) {
            // dd($params);
            $data = $this->storeRepository->create($params);
            $attendance_id = $params['attendance_id'];
            $latitude = $params['latitude'];
            $longitude = $params['longitude'];
            $store_id = $data->id;

            if(!empty($attendance_id) && !empty($latitude) && !empty($longitude)){
                updatelocationattendance($attendance_id,$latitude,$longitude,$store_id);
            }
            
            return response()->json(
                [
                    'status' => 201, 
                    'error' => false, 
                    'message' => 'Store Created', 
                    'data' => $data
                ], 
                Response::HTTP_CREATED
            );

        } else {
            return response()->json(
                [
                    'status' => 400, 
                    'error' => true, 
                    'message' => 'Validation', 
                    'data' => $validator->errors()->first()
                ]
            );
        }

    }

    public function noorder(Request $request)
    {
        // $newDetails = $request->only([
        //     'user_id', 'start_location', 'end_location', 'start_lat', 'end_lat', 'start_lng', 'end_lng', 'start_date', 'end_date', 'start_time', 'end_time'
        // ]);

        $data = $request->only([
            'user_id', 'store_id', 'comment', 'lat','lng','location','visit_image'
        ]);
        //dd($data);
        $stores = $this->storeRepository->noorderreasonupdate($data);
         //dd($stores);
        return response()->json(['error'=>false, 'resp'=>'No order Reason data created successfully','data'=>$stores]);
    }

    
    public function taskStoreList($id): JsonResponse{
        
        $start_date = date("Y-m-d", strtotime("last sunday"));
        $end_date = date("Y-m-d", strtotime("next saturday"));

        $tasks = DB::table('tasks')->where('user_id',$id)->where('start_date',$start_date)->where('end_date',$end_date)->first();

        $stores = array();
        if(!empty($tasks)){
            $stores = DB::table('task_details AS td')->select('stores.id','stores.store_name','stores.contact','stores.email','td.no_of_visit','td.comment')->leftJoin('stores', 'stores.id','td.store_id')->where('td.task_id',$tasks->id)->get()->toarray();
        }

        return response()->json(['error'=>false, 'resp'=>'store list successfully','data'=>$stores]);
    }

    public function invoices(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(),[
            'id' => ['required', 'integer', 'min:1', 'exists:stores,id'],
            'take' => ['integer'],
            'page' => ['integer']
        ]);

        $params = $request->except('_token');

        if(!$validator->fails()){
            $id = $params['id'];
            // $take = !empty($params['take'])?$params['take']:100;
            // $page = !empty($params['page'])?$params['page']:0;
            // $skip = ($take*$page);
            
            $invoices = DB::table('invoice AS i')
                        ->select('i.id','i.invoice_no','i.net_price','i.order_no','i.slip_no','i.payment_status','i.required_payment_amount')
                        ->where('i.store_id', $id)
                        ->orderBy('i.id','desc')
                        // ->skip($skip)->take($take)
                        ->get()->toarray();

            # last three payments

            $payment_collections = PaymentCollection::select('id','user_id','store_id','collection_amount','payment_type','bank_name','cheque_number','cheque_date','is_ledger_added')->where('store_id',$id)->orderBy('id','desc')->take(3)->get()->toarray();

            # unpaid amount

            $store_unpaid_amount = DB::table('invoice')->where('store_id',$id)->where('is_paid',0)->sum('required_payment_amount');
            
            return response()->json(['error'=>false,'message'=>"Store invoices", 'data'=> array('store_unpaid_amount'=>$store_unpaid_amount, 'payments'=>$payment_collections, 'invoices'=>$invoices) ],200);
        } else {
            return response()->json(['status' => 400, 'message' => $validator->errors()->first()],400);
        }
               
                
    }

    public function createnote(Request $request)
    {
        # save notes for store...
        $validator = Validator::make($request->all(),[
            'user_id' => ['required','exists:users,id'],
            'store_id' => ['required','exists:stores,id'],
            'details' => ['required'],
            'latitude' => ['string','nullable'],
            'longitude' => ['string','nullable'],
            'attendance_id' => ['nullable','exists:user_attendances,id'],
        ]);

        if($validator->fails()){
            return response()->json(['status' => 400, 'message' => $validator->errors()->first()],400);
        } else {
            $params = $request->except('_token');
            // dd($params);
            if(!in_array($params['user_id'],[1,2])){
                if(empty($request->latitude)){
                    return response()->json(['status'=>400,'message'=>"Please add latitude"], 400);
                }
                if(empty($request->longitude)){
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
            
            
            StoreNote::insert([
                'store_id' => $params['store_id'],
                'user_id' => $params['user_id'],
                'details' => $params['details']
            ]);

            if(!in_array($params['user_id'], [1,2])){
                $attendance_id = $params['attendance_id'];
                $latitude = $params['latitude'];
                $longitude = $params['longitude'];
                updatelocationattendance($attendance_id,$latitude,$longitude,$params['store_id']);
            }

            return response()->json(['error'=>false,'message'=>"Notes created successfully", 'data'=> array() ],200);
        }

        

    }

    public function listnote(Request $request)
    {
        # list note ...
        $validator = Validator::make($request->all(),[
            'user_id' => ['required','exists:users,id'],
            'store_id' => ['required','exists:stores,id']
        ]);

        if($validator->fails()){
            return response()->json(['status' => 400, 'message' => $validator->errors()->first()],400);
        } else {
            $params = $request->except('_token');

            $data = StoreNote::where('user_id',$params['user_id'])->where('store_id', $params['store_id'])->get();

            return response()->json(['error'=>false,'message'=>"My store notes", 'data'=> array('notes' => $data) ],200);
        }        
    }

}
