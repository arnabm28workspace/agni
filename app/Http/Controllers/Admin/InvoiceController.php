<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class InvoiceController extends Controller
{
    //
    public function index(Request $request)
    {
        # all...
        $paginate = 10;
        $term = !empty($request->term)?$request->term:'';
        $type = !empty($request->type)?$request->type:'';
        $data = DB::table('invoice AS i')->select('i.*','stores.store_name','stores.bussiness_name','stores.contact','stores.whatsapp')->leftJoin('stores', 'stores.id','i.store_id');
        $total = DB::table('invoice');

        if(!empty($term)){
            $data = $data->where('i.invoice_no','LIKE','%'.$term.'%');
            $total = $total->where('invoice_no', 'LIKE', '%'.$term.'%');
        }

        if(!empty($type)){
            if($type == 'gst'){
                $data = $data->where('i.is_gst', 1);
                $total = $total->where('is_gst', 1);
            } else if ($type == 'non_gst'){
                $data = $data->where('i.is_gst', 0);
                $total = $total->where('is_gst', 0);
            }
            
        }

        $total = $total->count();
        $data = $data->orderBy('i.id','desc')->paginate($paginate);
        $data = $data->appends([
            'term'=>$term,
            'page'=>$request->page,
            'type'=>$type
        ]);
        
        return view('admin.invoice.index', compact('data','term','type','total','paginate'));
    }

    public function store($id,Request $request)
    {
        $term = !empty($request->term)?$request->term:'';
        
        $user_name = '';
        $store = DB::table('stores')->find($id);
        $user_name = $store->store_name;
        DB::enableQueryLog();

        $data = DB::table('invoice')
                    ->select('invoice.*','users.name AS staff_name')
                    ->leftJoin('users','users.id','invoice.user_id')
                    ->where('invoice.store_id', $id)                   
                    ->where(function($query) use ($term){
                        $query->where('invoice.invoice_no', 'LIKE', '%'.$term.'%')->orWhere('invoice.slip_no', 'LIKE', '%'.$term.'%')->orWhere('invoice.order_no','LIKE', '%'.$term.'%');
                    })
                    ->paginate(5);

        // dd(DB::getQueryLog($data));
        // dd($data);

        $data = $data->appends(['term'=>$term,'page'=>$request->page]);            
        return view('admin.invoice.store', compact('data','term','user_name','id'));
        
    }

    public function staff($id,Request $request)
    {
        $term = !empty($request->term)?$request->term:'';
        
        $user_name = '';
        $staff = DB::table('users')->find($id);
        $user_name = $staff->name;

        $data = DB::table('invoice')
                        ->select('invoice.*','stores.store_name')
                        ->leftJoin('stores','stores.id','invoice.store_id')
                        ->where('invoice.user_id', $id)
                        ->where(function($query) use ($term){
                            $query->where('invoice.invoice_no', 'LIKE', '%'.$term.'%')->orWhere('invoice.slip_no', 'LIKE', '%'.$term.'%')->orWhere('invoice.order_no','LIKE', '%'.$term.'%');
                        })
                        // ->where('invoice.invoice_no', 'LIKE', '%'.$term.'%')
                        // ->orWhere('invoice.slip_no', 'LIKE', '%'.$term.'%')
                        // ->orWhere('invoice.order_no','LIKE', '%'.$term.'%')
                        ->paginate(5);

        $data = $data->appends(['term'=>$term,'page'=>$request->page]); 
        return view('admin.invoice.staff', compact('data','term','user_name','id'));
        
    }

    public function payments($id,$user_id=0,$user_type='',Request $request)
    {
        # code...
        $data = DB::table('invoice_payments AS ip')
                    ->select('ip.*','invoice.user_id AS order_creator_id','payment.staff_id AS payment_collector_id','order_creator.name AS order_creator_name','payment_collector.name AS payment_collector_name','payment.admin_id AS payment_admin_id','payment_collector_partner.name AS payment_collector_partner_name')
                    ->leftJoin('payment', 'payment.voucher_no', 'ip.voucher_no')
                    ->leftJoin('invoice', 'invoice.id','ip.invoice_id')
                    ->leftJoin('users AS order_creator', function($join) 
                    {
                        $join->on('invoice.user_id', '=', 'order_creator.id');
                        
                    })
                    ->leftJoin('users AS payment_collector', function($join) 
                    {
                        $join->on('payment.staff_id', '=', 'payment_collector.id');
                        
                    })
                    ->leftJoin('users AS payment_collector_partner', function($join) 
                    {
                        $join->on('payment.admin_id', '=', 'payment_collector_partner.id');
                        
                    })
                    ->where('ip.invoice_id',$id)
                    ->orderBy('ip.id','desc')
                    ->get()->toarray();

        // dd($data);
        return view('admin.invoice.payment', compact('data','user_type','user_id'));
    }

    
}
