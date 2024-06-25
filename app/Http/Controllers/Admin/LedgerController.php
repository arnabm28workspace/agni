<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LedgerController extends Controller
{
    
    public function getUsersByType(Request $request)
    {
        $type = $request->type;
        $search = $request->term;
        $data = array();
        if(!empty($type)){
            if($type == 'staff'){
                $data = DB::table('users')->select('id','name')->where('name','LIKE','%'.$search.'%')->where('type',2)->get();
            }else if($type == 'store'){
                $data = DB::table('stores')->select('id','store_name AS name')->where('store_name','LIKE','%'.$search.'%')->get();
            }else if($type == 'partner'){
                $data = DB::table('users')->select('id','name','email','mobile')->where('name','LIKE','%'.$search.'%')->where('type',1)->get();
            }else if($type == 'supplier'){
                $data = DB::table('suppliers')->select('id','name')->where('name','LIKE','%'.$search.'%')->where('status',1)->get();
            }
    
        }
        
        return $data;
    }

    public function getRequiredExpenses(Request $request)
    {
        $user_type = $request->user_type;
        $payment_for = 'debit';

        $data = DB::table('expense');
        if($user_type == 'store'){
            $data = $data->where('for_store', 1);
        }else if($user_type == 'staff'){
            $data = $data->where('for_staff', 1);
        }else if($user_type == 'partner'){
            $data = $data->where('for_partner', 1);
        }else if($user_type == 'supplier'){
            $data = $data->where('slug', 'supplier-payment');
        }

        if($payment_for == 'credit'){
            $data = $data->where('for_credit', 1);
        }else{
            $data = $data->where('for_debit', 1);
        }
        $data = $data->where('status', 1)->get();

        return $data;
    }

    public function getBankList(Request $request)
    {
        $search = !empty($request->term)?$request->term:'';
        $data = DB::table('bank_lists')->where('name', 'LIKE', '%'.$search.'%')->orderBy('name','asc')->get();

        return $data;
    }

    
}
