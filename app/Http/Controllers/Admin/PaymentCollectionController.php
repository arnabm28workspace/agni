<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentCollection;
use App\Models\Store;
use App\Models\Order;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PaymentCollectionController extends Controller
{
    public function index(Request $request)
    {
        $paginate = 10;
        $store_id = (isset($_GET['store_id']) && $_GET['store_id']!='')?$_GET['store_id']:'';
        $staff_id = (isset($_GET['staff_id']) && $_GET['staff_id']!='')?$_GET['staff_id']:'';

        $data = PaymentCollection::with('stores')->with('users')
                ->when($store_id!='', function($query) use ($store_id){
                    $query->where('store_id', '=', $store_id);
                })
                ->when($staff_id!='', function($query) use ($staff_id){
                    $query->where('user_id', '=', $staff_id);
                })
                ->orderBy('id','desc')->paginate($paginate);
       
        $data = $data->appends(['store_id'=>$store_id,'staff_id'=>$staff_id,'page'=>$request->page]);
        $users = User::whereIn('designation',[0,1])->get();  /* partners and salesman */
        $stores = Store::get();
        $total = PaymentCollection::count();
        
        return view('admin.paymentcollection.index', compact('data','users','stores','total','paginate'));
    }

    public function approve($id){
        $data = PaymentCollection::find($id);

        $is_approve = $data->is_approve;

        if ($is_approve==0) {
            

            $store_id = $data->store_id;

            $collected_amount = $data->collection_amount;
            $amount_redeemed = $collected_amount;

            //$orders = Order::where('store_id','=',$store_id)->where('final_amount','!=','paid_amount')->get();

            $orders = DB::select("select * from orders where store_id=$store_id and final_amount!=paid_amount");

            foreach ($orders as $order) {
                $order_id = $order->id;
                // code...
                $pending_amount = $order->final_amount - $order->paid_amount;

                if ($amount_redeemed>0 and $pending_amount>0) {
                    if ($pending_amount>$amount_redeemed) {
                        $result = DB::select("update orders set paid_amount=paid_amount+$amount_redeemed where id='$order_id'");

                        $amount_redeemed = $amount_redeemed - $amount_redeemed;
                    }else{
                        $result = DB::select("update orders set paid_amount=paid_amount+$pending_amount where id='$order_id'");

                        $result = DB::select("update orders set is_paid=1 where id='$order_id'");

                        $amount_redeemed = $amount_redeemed - $pending_amount;
                    }
                    // code...
                }



            }
            // echo "<pre>";
            // print_r($orders);
            // die();
            $data->is_approve = 1;
            $data->save();
        }
        

        return redirect()->route('admin.paymentcollection.index');
    }
}
