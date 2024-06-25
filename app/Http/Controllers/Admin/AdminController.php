<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\UserInterface;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\Order;
use App\Models\Supplier;
use App\User;
use App\Models\Store;
use App\Models\StoreNote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:web');
    }
    
    /**
     * This method is for admin dashboard
     *
     */
    public function home(Request $request)
    {        
        // die("Hello");
        $data = (object)[];
        $data->users = User::where('type',2)->count(); /* Staff count */
        $data->suppliers = Supplier::count();        
        $data->products = Product::count();
        $data->stores = Store::count();

        $store_sales_data = $store_due_payments =  array();
        $store_due_payments = DB::table('invoice')->select('invoice.store_id','stores.store_name')->selectRaw("SUM(invoice.required_payment_amount) AS amount")->leftJoin('stores', 'stores.id','invoice.store_id')->where('invoice.payment_status', '!=', 2)->orderByRaw('SUM(invoice.required_payment_amount) DESC')->groupBy('invoice.store_id')->take(10)->get();
        
        $data->store_due_payments = $store_due_payments;

        $store_sales_data = DB::table('orders')->select('orders.store_id','stores.store_name')->selectRaw("SUM(orders.final_amount) AS amount")->leftJoin('stores','stores.id','orders.store_id')->groupBy('orders.store_id')->orderByRaw('SUM(orders.final_amount) DESC')->take(10)->get();
        
        $data->store_sales_data = $store_sales_data;

        
        return view('admin.home', compact('data'));
    }
    
    /*
    public function home_old(Request $request)
    {
        
        $data = (object)[];
        $data->users = User::where('status', 1)->count(); 
        $data->suppliers = Supplier::where('status', 1)->count();        
        $data->products = Product::latest('id')->get();
        $data->orders = PurchaseOrder::groupBy('unique_id')
                            ->selectRaw('*, sum(total_price) as amount')
                            ->with('supplier:id,name')
                            ->limit(5)
                            ->get();

        $store_sales_data = $store_due_payments =  array();
        $stores = Store::where('status','1')->get();
        $data->stores = $stores;

        foreach($stores as $store){
            $store->total_sales_value = $this->fetchStoreWiseSales($store->id);            
            $store->duePaymentStores = $this->duePaymentStores($store->id);
            // echo $store->id;
            // dd($store->duePaymentStores);
            if($store->total_sales_value>0){
                array_push($store_sales_data,$store);
            }

            if($store->duePaymentStores > 0){
                array_push($store_due_payments,$store);
            }

            $store->due_payment_amount = $this->duePaymentStores($store->id);
            
        }

        

        $data->store_sales_data = $store_sales_data;
        $data->store_due_payments = $store_due_payments;

        // dd($store_due_payments);

        $user_sales_data = array();
        $users = User::where('status','1')->where('type','1')->get();

        foreach($users as $user){
            $user->total_sales_value = $this->fetchUserWiseSales($user->id);
            // if($user->total_sales_value>0){
            //     array_push($user_sales_data,$user);
            // }
            array_push($user_sales_data,$user);
            
        }

        $data->user_sales_data = $user_sales_data;
        return view('admin.home', compact('data'));
    }
    */


    private function fetchStoreWiseSales($shop_id){
        $result = DB::select("select sum(final_amount) as total_sales_value from orders where store_id='$shop_id'");

        if (count($result)>0) {
            return $result[0]->total_sales_value;
        }else{
            return 0;
        }
    }

    private function fetchUserWiseSales($user_id){
        $result = DB::select("select sum(final_amount) as total_sales_value from orders where user_id='$user_id'");

        if (count($result)>0) {
            return $result[0]->total_sales_value;
        }else{
            return 0;
        }
    }

    public function storeWiseReport(){
        $start_date = (isset($_GET['start_date']) && $_GET['start_date']!='')?$_GET['start_date']:'2022-01-01';
        $end_date = (isset($_GET['end_date']) && $_GET['end_date']!='')?$_GET['end_date']:'2022-12-31';

        $store_sales_data = array();
        $stores = Store::where('status','1')->get();

        foreach($stores as $store){
            // $data = $this->fetchDateStoreWiseSales($store->id,$start_date,$end_date);
            // echo "<pre>";
            // print_r($data);
            // die();
            $store->total_sales_value = $this->fetchDateStoreWiseSales($store->id,$start_date,$end_date)['total_sales_value'];
            $store->order_count = $this->fetchDateStoreWiseSales($store->id,$start_date,$end_date)['order_count'];
                        
            array_push($store_sales_data,$store);
        }   

        return view('admin.report.store_wise_report', compact('store_sales_data'));
    }

    public function staffWiseReport(){
        $start_date = (isset($_GET['start_date']) && $_GET['start_date']!='')?$_GET['start_date']:'2022-01-01';
        $end_date = (isset($_GET['end_date']) && $_GET['end_date']!='')?$_GET['end_date']:'2022-12-31';

        $user_sales_data = array();
        $users = User::where('status','1')->where('type','1')->get();

        foreach($users as $user){
            // $data = $this->fetchDateuserWiseSales($user->id,$start_date,$end_date);
            // echo "<pre>";
            // print_r($data);
            // die();
            $user->total_sales_value = $this->fetchDateStaffWiseSales($user->id,$start_date,$end_date)['total_sales_value'];
            $user->order_count = $this->fetchDateStaffWiseSales($user->id,$start_date,$end_date)['order_count'];
            
            array_push($user_sales_data,$user);
        }   

        return view('admin.report.user_sales_report', compact('user_sales_data'));
    }


    private function fetchDateStoreWiseSales($shop_id,$start_date,$end_date){
        $data = array();

        $result = DB::select("select sum(final_amount) as total_sales_value from orders where store_id='$shop_id' and created_at>'$start_date' and created_at<'$end_date'");

        if (count($result)>0) {
            $data['total_sales_value'] = $result[0]->total_sales_value;
        }else{
            $data['total_sales_value'] = 0;
        }

        $result = DB::select("select count(id) as order_count from orders where store_id='$shop_id' and created_at>'$start_date' and created_at<'$end_date'");

        if (count($result)>0) {
            $data['order_count'] = $result[0]->order_count;
        }else{
            $data['order_count'] = 0;
        }

        return $data;
    }

    private function fetchDateStaffWiseSales($user_id,$start_date,$end_date){
        $data = array();

        $result = DB::select("select sum(final_amount) as total_sales_value from orders where user_id='$user_id' and created_at>'$start_date' and created_at<'$end_date'");

        if (count($result)>0) {
            $data['total_sales_value'] = $result[0]->total_sales_value;
        }else{
            $data['total_sales_value'] = 0;
        }

        $result = DB::select("select count(id) as order_count from orders where user_id='$user_id' and created_at>'$start_date' and created_at<'$end_date'");

        if (count($result)>0) {
            $data['order_count'] = $result[0]->order_count;
        }else{
            $data['order_count'] = 0;
        }

        return $data;
    }

    public function paymentCollectionReport(){
        $start_date = (isset($_GET['start_date']) && $_GET['start_date']!='')?$_GET['start_date']:'2022-01-01';
        $end_date = (isset($_GET['end_date']) && $_GET['end_date']!='')?$_GET['end_date']:'2022-12-31';

        $store_payments_data = array();
        $stores = Store::where('status','1')->get();

        foreach($stores as $store){
            $store->total_collection_amount = $this->fetchDateWisePayment($store->id,$start_date,$end_date);
            
            array_push($store_payments_data,$store);
        }  

        $user_payments_data = array();
        $users = User::where('status','1')->where('type','1')->get();

        foreach($users as $user){
            $user->total_collection_amount = $this->fetchUserWisePayment($user->id,$start_date,$end_date);
            
            array_push($user_payments_data,$user);
        }   

        return view('admin.report.payment_collection_report', compact('store_payments_data','user_payments_data'));
    }

    private function fetchDateWisePayment($shop_id,$start_date,$end_date){
        $result = DB::select("select sum(collection_amount) as total_collection_amount from payment_collections where store_id='$shop_id' and created_at>'$start_date' and created_at<'$end_date'");

        if (count($result)>0) {
            return $result[0]->total_collection_amount;
        }else{
            return 0;
        }
    }

    private function fetchUserWisePayment($user_id,$start_date,$end_date){
        $result = DB::select("select sum(collection_amount) as total_collection_amount from payment_collections where user_id='$user_id' and created_at>'$start_date' and created_at<'$end_date'");

        if (count($result)>0) {
            return $result[0]->total_collection_amount;
        }else{
            return 0;
        }
    }

    private function duePaymentStores($store_id)
    {
        // $data = DB::table('invoice')->select('invoice.store_id','SUM(invoice.required_payment_amount) AS due_payment_amount','stores.store_name')->leftJoin('stores','stores.id','invoice.store_id')->where('invoice.store_id',$store_id)->where('invoice.payment_status','!=',2)->get();
        $data = DB::table('invoice')->where('store_id',$store_id)->where('payment_status', '!=', 2)->sum('required_payment_amount');
        return $data;
    }

    public function ledgerUser(Request $request)
    {
        $designation = Auth::user()->designation;
        $auth_type = Auth::user()->type;
        if($auth_type == 2){
            $userAccesses = userAccesses($designation,11);
            if(!$userAccesses){
                abort(401);
            }
        }


        $user_type = !empty($request->user_type)?$request->user_type:'';
        $store_id = !empty($request->store_id)?$request->store_id:0;
        $staff_id = !empty($request->staff_id)?$request->staff_id:0;
        $admin_id = !empty($request->admin_id)?$request->admin_id:0;
        $supplier_id = !empty($request->supplier_id)?$request->supplier_id:0;
        $select_user_name = !empty($request->select_user_name)?$request->select_user_name:'';
        $from_date = !empty($request->from_date)?$request->from_date:date('Y-m-01', strtotime(date('Y-m-d')));
        $to_date = !empty($request->to_date)?$request->to_date:date('Y-m-d');
        // $to_date = !empty($request->to_date)?$request->to_date:date('Y-m-t', strtotime(date('Y-m-d')));
        if(Auth::user()->type == 2){
            if(!empty($store_id)){
                // die("Hi");
                $bank_cash = "bank";
            }else {
                $bank_cash = !empty($request->bank_cash)?$request->bank_cash:'';
            }
            
        } else {
            $bank_cash = !empty($request->bank_cash)?$request->bank_cash:'';
        }


        $sort_by = !empty($request->sort_by)?$request->sort_by:'asc';

        $data = $outstanding = array();
        $day_opening_amount = $is_opening_bal =  0;
        $is_opening_bal_showable = 1;
        $opening_bal_date = "";
        
        $store = DB::table('stores')->select('id','store_name AS name')->where('status',1)->get();
        $staff = DB::table('users')->select('id','name')->where('status',1)->get();

        
        if(!empty($user_type)){
            
            DB::enableQueryLog();
            $data = DB::table('ledger AS l')->select('l.*','p.voucher_no','p.payment_in','p.amount AS payment_amount','p.payment_mode','p.chq_utr_no','p.narration');
            
            $opening_bal = DB::table('ledger');

            if($user_type == 'store' && !empty($store_id)){
                $data = $data->where('l.user_type', 'store')->where('l.store_id',$store_id);
                
                $opening_bal = $opening_bal->where('user_type',$user_type)->where('store_id',$store_id);
            }else if($user_type == 'staff'  && !empty($staff_id)){
                $data = $data->where('l.user_type', 'staff')->where('l.staff_id',$staff_id);
                
                $opening_bal = $opening_bal->where('user_type',$user_type)->where('staff_id',$staff_id);
            }else if($user_type == 'partner' && !empty($admin_id)){
                $data = $data->where('l.user_type', 'partner')->where('l.admin_id',$admin_id);
                
                $opening_bal = $opening_bal->where('user_type',$user_type)->where('admin_id',$admin_id);
            }else if($user_type == 'supplier' && !empty($supplier_id)){
                $data = $data->where('l.user_type','supplier')->where('l.supplier_id',$supplier_id);
                $opening_bal = $opening_bal->where('user_type',$user_type)->where('supplier_id',$supplier_id);
            }

            $check_ob_exist_store = DB::table('ledger')->where('purpose','opening_balance')->where('user_type', 'store')->where('store_id',$store_id)->orderBy('id','asc')->first();

            if(!empty($check_ob_exist_store)){
                $from_date = ($request->from_date < $check_ob_exist_store->entry_date) ? $check_ob_exist_store->entry_date : $request->from_date;
                $is_opening_bal = 1;
                $opening_bal_date = $check_ob_exist_store->entry_date;

                if($from_date == $check_ob_exist_store->entry_date){                    
                    $is_opening_bal_showable = 0;                    
                } else {
                    $opening_bal = $opening_bal->whereRaw(" entry_date BETWEEN '".$check_ob_exist_store->entry_date."' AND '".date('Y-m-d', strtotime('-1 day', strtotime($from_date)))."'  ");
                }                
                
            } else {
                // die('Hi');
                $opening_bal = $opening_bal->whereRaw(" entry_date <= '".date('Y-m-d', strtotime('-1 day', strtotime($from_date)))."'  ");
            } 

            /* +++++++++++++++++++ */

            $check_ob_exist_partner = DB::table('ledger')->where('purpose','opening_balance')->where('user_type', 'partner')->where('admin_id',$admin_id)->orderBy('id','asc')->first();

            if(!empty($check_ob_exist_partner)){
                $from_date = ($request->from_date < $check_ob_exist_partner->entry_date) ? $check_ob_exist_partner->entry_date : $request->from_date;
                $is_opening_bal = 1;
                $opening_bal_date = $check_ob_exist_partner->entry_date;

                if($from_date == $check_ob_exist_partner->entry_date){                    
                    $is_opening_bal_showable = 0;                    
                } else {
                    $opening_bal = $opening_bal->whereRaw(" entry_date BETWEEN '".$check_ob_exist_partner->entry_date."' AND '".date('Y-m-d', strtotime('-1 day', strtotime($from_date)))."'  ");
                }                
                
            } else {
                // die('Hi');
                $opening_bal = $opening_bal->whereRaw(" entry_date <= '".date('Y-m-d', strtotime('-1 day', strtotime($from_date)))."'  ");
            } 
              
            if(!empty($from_date) && !empty($to_date)){
                $data = $data->whereRaw("l.entry_date BETWEEN '".$from_date."' AND '".$to_date."' ");
            }
            
            if(Auth::user()->type == 2){
                $opening_bal = $opening_bal->where('is_gst', 1);
            }
            $opening_bal = $opening_bal->orderBy('entry_date',$sort_by);  
            $opening_bal = $opening_bal->orderBy('updated_at',$sort_by);  
            $opening_bal = $opening_bal->get();

            foreach($opening_bal as $ob){
                if(!empty($ob->is_credit)){
                    $credit_amount = $ob->transaction_amount;
                    $day_opening_amount += $ob->transaction_amount;
                }
                if(!empty($ob->is_debit)){
                    $debit_amount = $ob->transaction_amount;
                    $day_opening_amount -= $ob->transaction_amount;
                }
            }

            if(!empty($bank_cash)){
                $data = $data->where('l.bank_cash', $bank_cash);
            }

            if(Auth::user()->type == 2){
                $data = $data->where('l.is_gst', 1);
            }

            // dd($day_opening_amount);
            $data = $data->leftJoin('payment AS p','p.id','l.payment_id');
            $data = $data->orderBy('l.entry_date',$sort_by);  
            $data = $data->orderBy('l.updated_at',$sort_by);  
            $data = $data->get()->toarray();             

        }

        // dd($data);
        
        return view('admin.report.ledger', compact('store','staff','data','user_type','store_id','staff_id','admin_id','supplier_id','select_user_name','from_date','to_date','sort_by','day_opening_amount','is_opening_bal','is_opening_bal_showable','opening_bal_date','bank_cash'));
    }

    

    public function ledgerPDF(Request $request)
    {
        $user_type = !empty($request->user_type)?$request->user_type:'';
        $store_id = !empty($request->store_id)?$request->store_id:0;
        $staff_id = !empty($request->staff_id)?$request->staff_id:0;
        $admin_id = !empty($request->admin_id)?$request->admin_id:0;
        $supplier_id = !empty($request->supplier_id)?$request->supplier_id:0;
        $select_user_name = !empty($request->select_user_name)?$request->select_user_name:'';
        $from_date = !empty($request->from_date)?$request->from_date:'';
        $to_date = !empty($request->to_date)?$request->to_date:'';
        $sort_by = !empty($request->sort_by)?$request->sort_by:'asc';
        $bank_cash = !empty($request->bank_cash)?$request->bank_cash:'';

        $data = $outstanding = array();
        $day_opening_amount = $is_opening_bal =  0;
        $is_opening_bal_showable = 1;
        $opening_bal_date = "";
        
        
        if(!empty($user_type)){
            
            DB::enableQueryLog();
            $data = DB::table('ledger AS l')->select('l.*','p.voucher_no','p.payment_in','p.amount AS payment_amount','p.payment_mode','p.chq_utr_no','p.narration');
            
            $opening_bal = DB::table('ledger');

            if($user_type == 'store' && !empty($store_id)){
                $data = $data->where('l.user_type', 'store')->where('l.store_id',$store_id);
                
                $opening_bal = $opening_bal->where('user_type',$user_type)->where('store_id',$store_id);
            }else if($user_type == 'staff'  && !empty($staff_id)){
                $data = $data->where('l.user_type', 'staff')->where('l.staff_id',$staff_id);
                
                $opening_bal = $opening_bal->where('user_type',$user_type)->where('staff_id',$staff_id);
            }else if($user_type == 'partner' && !empty($admin_id)){
                $data = $data->where('l.user_type', 'partner')->where('l.admin_id',$admin_id);
                
                $opening_bal = $opening_bal->where('user_type',$user_type)->where('admin_id',$admin_id);
            }else if($user_type == 'supplier' && !empty($supplier_id)){
                $data = $data->where('l.user_type','supplier')->where('l.supplier_id',$supplier_id);
                $opening_bal = $opening_bal->where('user_type',$user_type)->where('supplier_id',$supplier_id);
            }

            $check_ob_exist_store = DB::table('ledger')->where('purpose','opening_balance')->where('user_type', 'store')->where('store_id',$store_id)->orderBy('id','asc')->first();

            if(!empty($check_ob_exist_store)){
                $from_date = ($request->from_date < $check_ob_exist_store->entry_date) ? $check_ob_exist_store->entry_date : $request->from_date;
                $is_opening_bal = 1;
                $opening_bal_date = $check_ob_exist_store->entry_date;

                if($from_date == $check_ob_exist_store->entry_date){                    
                    $is_opening_bal_showable = 0;                    
                } else {
                    $opening_bal = $opening_bal->whereRaw(" entry_date BETWEEN '".$check_ob_exist_store->entry_date."' AND '".date('Y-m-d', strtotime('-1 day', strtotime($from_date)))."'  ");
                }                
                
            } else {
                // die('Hi');
                $opening_bal = $opening_bal->whereRaw(" entry_date <= '".date('Y-m-d', strtotime('-1 day', strtotime($from_date)))."'  ");
            } 

            /* +++++++++++++++++++ */

            $check_ob_exist_partner = DB::table('ledger')->where('purpose','opening_balance')->where('user_type', 'partner')->where('admin_id',$admin_id)->orderBy('id','asc')->first();

            if(!empty($check_ob_exist_partner)){
                $from_date = ($request->from_date < $check_ob_exist_partner->entry_date) ? $check_ob_exist_partner->entry_date : $request->from_date;
                $is_opening_bal = 1;
                $opening_bal_date = $check_ob_exist_partner->entry_date;

                if($from_date == $check_ob_exist_partner->entry_date){                    
                    $is_opening_bal_showable = 0;                    
                } else {
                    $opening_bal = $opening_bal->whereRaw(" entry_date BETWEEN '".$check_ob_exist_partner->entry_date."' AND '".date('Y-m-d', strtotime('-1 day', strtotime($from_date)))."'  ");
                }                
                
            } else {
                // die('Hi');
                $opening_bal = $opening_bal->whereRaw(" entry_date <= '".date('Y-m-d', strtotime('-1 day', strtotime($from_date)))."'  ");
            } 

              
            if(!empty($from_date) && !empty($to_date)){
                $data = $data->whereRaw("l.entry_date BETWEEN '".$from_date."' AND '".$to_date."' ");
            }

            if(Auth::user()->type == 2){
                $opening_bal = $opening_bal->where('is_gst', 1);
            }
            
            $opening_bal = $opening_bal->orderBy('entry_date',$sort_by);  
            $opening_bal = $opening_bal->orderBy('updated_at',$sort_by);  
            $opening_bal = $opening_bal->get();

            // dd($opening_bal);

            foreach($opening_bal as $ob){
                if(!empty($ob->is_credit)){
                    $credit_amount = $ob->transaction_amount;
                    $day_opening_amount += $ob->transaction_amount;
                }
                if(!empty($ob->is_debit)){
                    $debit_amount = $ob->transaction_amount;
                    $day_opening_amount -= $ob->transaction_amount;
                }
            }

            if(!empty($bank_cash)){
                $data = $data->where('l.bank_cash', $bank_cash);
            }

            if(Auth::user()->type == 2){
                $data = $data->where('l.is_gst', 1);
            }

            // dd($day_opening_amount);
            $data = $data->leftJoin('payment AS p','p.id','l.payment_id');
            $data = $data->orderBy('l.entry_date',$sort_by);  
            $data = $data->orderBy('l.updated_at',$sort_by);  
            $data = $data->get()->toarray(); 
            
            // dd($data);

        }

        $ledgerpdfname = ucwords($user_type)."-".date('Y-m-d-H-i-s-A')."";

        $pdf = Pdf::loadView('admin.report.ledger-pdf', compact('data','user_type','store_id','staff_id','admin_id','supplier_id','select_user_name','from_date','to_date','day_opening_amount','is_opening_bal','is_opening_bal_showable','opening_bal_date','bank_cash'));
        return $pdf->download($ledgerpdfname.'.pdf');
        
        
    }

    public function ledgerExcel(Request $request)
    {
        
        $user_type = !empty($request->user_type)?$request->user_type:'';
        $store_id = !empty($request->store_id)?$request->store_id:0;
        $staff_id = !empty($request->staff_id)?$request->staff_id:0;
        $admin_id = !empty($request->admin_id)?$request->admin_id:0;
        $supplier_id = !empty($request->supplier_id)?$request->supplier_id:0;
        $select_user_name = !empty($request->select_user_name)?$request->select_user_name:'';
        $from_date = !empty($request->from_date)?$request->from_date:'';
        $to_date = !empty($request->to_date)?$request->to_date:'';
        $sort_by = !empty($request->sort_by)?$request->sort_by:'asc';

        

        

        $fileName = ucwords($user_type)."-".date('Y-m-d-H-i-s-A').".csv";
        
        $data = $outstanding = array();
        $day_opening_amount = $is_opening_bal =  0;
        $is_opening_bal_showable = 1;
        $opening_bal_date = "";
        
        
        if(!empty($user_type)){
            
            DB::enableQueryLog();
            $data = DB::table('ledger AS l')->select('l.*','p.voucher_no','p.payment_in','p.amount AS payment_amount','p.payment_mode','p.chq_utr_no','p.narration');
            
            $opening_bal = DB::table('ledger');

            if($user_type == 'store' && !empty($store_id)){
                $data = $data->where('l.user_type', 'store')->where('l.store_id',$store_id);
                
                $opening_bal = $opening_bal->where('user_type',$user_type)->where('store_id',$store_id);
            }else if($user_type == 'staff'  && !empty($staff_id)){
                $data = $data->where('l.user_type', 'staff')->where('l.staff_id',$staff_id);
                
                $opening_bal = $opening_bal->where('user_type',$user_type)->where('staff_id',$staff_id);
            }else if($user_type == 'partner' && !empty($admin_id)){
                $data = $data->where('l.user_type', 'partner')->where('l.admin_id',$admin_id);
                
                $opening_bal = $opening_bal->where('user_type',$user_type)->where('admin_id',$admin_id);
            }else if($user_type == 'supplier' && !empty($supplier_id)){
                $data = $data->where('l.user_type','supplier')->where('l.supplier_id',$supplier_id);
                $opening_bal = $opening_bal->where('user_type',$user_type)->where('supplier_id',$supplier_id);
            }

            $check_ob_exist_store = DB::table('ledger')->where('purpose','opening_balance')->where('user_type', 'store')->where('store_id',$store_id)->orderBy('id','asc')->first();

            if(!empty($check_ob_exist_store)){
                $from_date = ($request->from_date < $check_ob_exist_store->entry_date) ? $check_ob_exist_store->entry_date : $request->from_date;
                $is_opening_bal = 1;
                $opening_bal_date = $check_ob_exist_store->entry_date;

                if($from_date == $check_ob_exist_store->entry_date){                    
                    $is_opening_bal_showable = 0;                    
                } else {
                    $opening_bal = $opening_bal->whereRaw(" entry_date BETWEEN '".$check_ob_exist_store->entry_date."' AND '".date('Y-m-d', strtotime('-1 day', strtotime($from_date)))."'  ");
                }                
                
            } else {
                // die('Hi');
                $opening_bal = $opening_bal->whereRaw(" entry_date <= '".date('Y-m-d', strtotime('-1 day', strtotime($from_date)))."'  ");
            } 

            /* +++++++++++++++++++ */

            $check_ob_exist_partner = DB::table('ledger')->where('purpose','opening_balance')->where('user_type', 'partner')->where('admin_id',$admin_id)->orderBy('id','asc')->first();

            if(!empty($check_ob_exist_partner)){
                $from_date = ($request->from_date < $check_ob_exist_partner->entry_date) ? $check_ob_exist_partner->entry_date : $request->from_date;
                $is_opening_bal = 1;
                $opening_bal_date = $check_ob_exist_partner->entry_date;

                if($from_date == $check_ob_exist_partner->entry_date){                    
                    $is_opening_bal_showable = 0;                    
                } else {
                    $opening_bal = $opening_bal->whereRaw(" entry_date BETWEEN '".$check_ob_exist_partner->entry_date."' AND '".date('Y-m-d', strtotime('-1 day', strtotime($from_date)))."'  ");
                }                
                
            } else {
                // die('Hi');
                $opening_bal = $opening_bal->whereRaw(" entry_date <= '".date('Y-m-d', strtotime('-1 day', strtotime($from_date)))."'  ");
            } 

              
            if(!empty($from_date) && !empty($to_date)){
                $data = $data->whereRaw("l.entry_date BETWEEN '".$from_date."' AND '".$to_date."' ");
            }

            if(Auth::user()->type == 2){
                $opening_bal = $opening_bal->where('is_gst', 1);
            }
            
            $opening_bal = $opening_bal->orderBy('entry_date',$sort_by);  
            $opening_bal = $opening_bal->orderBy('updated_at',$sort_by);  
            $opening_bal = $opening_bal->get();

            // dd($opening_bal);

            foreach($opening_bal as $ob){
                if(!empty($ob->is_credit)){
                    $credit_amount = $ob->transaction_amount;
                    $day_opening_amount += $ob->transaction_amount;
                }
                if(!empty($ob->is_debit)){
                    $debit_amount = $ob->transaction_amount;
                    $day_opening_amount -= $ob->transaction_amount;
                }
            }

            if(!empty($bank_cash)){
                $data = $data->where('l.bank_cash', $bank_cash);
            }

            if(Auth::user()->type == 2){
                $data = $data->where('l.is_gst', 1);
            }

            $data = $data->leftJoin('payment AS p','p.id','l.payment_id');
            $data = $data->orderBy('l.entry_date',$sort_by);  
            $data = $data->orderBy('l.updated_at',$sort_by);  
            $data = $data->get()->toarray(); 

            /* ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ */
            
            $myArr = array();
            foreach($data  as  $item){
                $myArr[] = array(
                    'is_credit' => $item->is_credit,
                    'is_debit' => $item->is_debit,
                    'purpose' => $item->purpose,
                    'transaction_id' => $item->transaction_id,
                    'transaction_amount' => $item->transaction_amount,
                    'entry_date' => $item->entry_date,
                    'payment_mode' => $item->payment_mode,
                    'bank_cash' => $item->bank_cash
                ); 
                
            }

            
            
            
            if(!empty($is_opening_bal_showable)){
                $is_credit = $is_debit = 0;
                $getCrDrOB = getCrDr($day_opening_amount);
                if($getCrDrOB == 'Cr'){
                    $is_credit = 1;
                } else if($getCrDrOB == 'Dr'){
                    $is_debit = 1;
                } else if($getCrDrOB == ''){
                    
                }
                $ob_arr = array(
                    'is_credit' => $is_credit,
                    'is_debit' => $is_debit,
                    'purpose' => "Opening Balance",
                    'transaction_id' => '',
                    'transaction_amount' => replaceMinusSign($day_opening_amount),
                    'entry_date' => date('d/m/Y', strtotime($from_date)),
                    'payment_mode' => '',
                    'bank_cash' => ''
                );

                array_unshift($myArr,$ob_arr);
                
            }
            // echo '<pre>'; print_r($myArr);
            // echo '<pre>'; print_r($data);
        }

        // die;

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Date','Transaction Id / Voucher No', 'Purpose', 'Debit', 'Credit',  'Closing');

        $callback = function() use($myArr, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            $net_value = 0;
            
            foreach ($myArr as $item) {
                $creditAmt = $debitAmt = '';
                if($item['is_credit'] == 1){
                    $creditAmt = $item['transaction_amount'];
                    $net_value += $item['transaction_amount'];
                }
                if($item['is_debit'] == 1){
                    $debitAmt = ($item['transaction_amount']);
                    $net_value -= $item['transaction_amount'];
                }
                // echo $net_value; die;
                
                $show_payment_mode = !empty($item['bank_cash']) ? "( ".ucwords($item['bank_cash'])." )" : "";
                $row['Date']  = date('d/m/Y', strtotime($item['entry_date']));
                $row['Transaction Id / Voucher No'] = $item['transaction_id'];
                $row['Purpose'] = ucwords(str_replace("_"," ",$item['purpose']))." ".$show_payment_mode;                
                $row['Debit']  = replaceMinusSign($debitAmt);
                $row['Credit']    = $creditAmt;
                $row['Closing']  =  replaceMinusSign($net_value)." ".getCrDr($net_value);

                fputcsv($file, array($row['Date'], $row['Transaction Id / Voucher No'],$row['Purpose'], $row['Debit'], $row['Credit'], $row['Closing']));                
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function store_notes(Request $request)
    {
        # store notes ...
        $paginate = 10;

        $store_id = !empty($request->store_id)?$request->store_id:'';
        $user_id = !empty($request->user_id)?$request->user_id:'';

        $from_date = !empty($request->from_date)?$request->from_date:date('Y-m-d');
        $to_date = !empty($request->to_date)?$request->to_date:date('Y-m-d');

        $store = Store::get();
        $staff = User::where('designation', 1)->get();

        $data = StoreNote::select();

        if(!empty($store_id)){
            $data = $data->where('store_id', $store_id);
        }
        if(!empty($user_id)){
            $data = $data->where('user_id', $user_id);
        }
        
        $data = $data->whereRaw("DATE_FORMAT(created_at,'%Y-%m-%d') BETWEEN '".$from_date."' AND '".$to_date."'  ");

        $data = $data->orderBy('id', 'desc')->paginate($paginate);

        $data = $data->appends([            
            'page' => $request->page,
            'store_id' => $store_id,
            'user_id' => $user_id,
            'from_date' => $from_date,
            'to_date' => $to_date
        ]);

        return view('admin.store.notes', compact('data','store_id','user_id','store','staff','from_date','to_date','paginate'));
    }

    public function travel_report(Request $request)
    {
        #  total ...
        $user_id = !empty($request->user_id)?$request->user_id:'';
        $from_date = !empty($request->from_date)?$request->from_date:date('Y-m-d');
        $to_date = !empty($request->to_date)?$request->to_date:date('Y-m-d');


        $data = DB::table('user_attendances AS ua');
        $data = $data->selectRaw("ua.user_id,users.name,SUM(ua.total_distance) AS sum_total_distance");
        // if(empty($user_id)){
        $data = $data->groupBy('user_id');
        // }
        
        $data = $data->leftJoin('users', 'users.id','ua.user_id');
        $data = $data->whereRaw("ua.start_date BETWEEN '".$from_date."' AND '".$to_date."'");

        $data = $data->get();
        // $data = $data->where('user_id', 6)->get();

        // dd($data);


        return view('admin.report.travel', compact('data','user_id','from_date','to_date'));
        
    }
    
}
