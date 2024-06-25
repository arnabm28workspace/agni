<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class ExpenseController extends Controller
{
    //

    /* List Expense Type */

    public function types(Request $request)
    {
        # partner debit expense types...        
        
        $payment_for = 'debit';
        $data = DB::table('expense')->select('id','title','for_partner');        
        $data = $data->where('for_partner', 1);       
        $data = $data->where('for_debit', 1)->where('status', 1)->orderBy('title','asc')->get();

        return response()->json(['error' => false, 'message' => 'Expense List', 'data' => array('types'=>$data) ], 200);
    }

    /* List Expense */

    public function list($admin_id=0)
    {
        # expense list...        

        if(!empty($admin_id)){
            if(in_array($admin_id,[1,2])){
                $data = DB::table('payment')->where('admin_id',$admin_id)->where('expense_id','!=',0)->orderBy('payment_date','desc')->orderBy('id','desc')->get();
                $count_data = DB::table('payment')->where('expense_id','!=',0)->count();

                // echo '<pre>'; print_r($data);
                return response()->json(['error' => false, 'message' => 'Expense List', 'data' => array('count_data'=>$count_data,'expenses'=>$data) ], 200);
            } else {
                return response()->json(['error' => true, 'message' => 'You have no authorization for accessing expense list', 'data' => array() ], 200);
            }
            
        } else {
            return response()->json(['error' => true, 'message' => 'Please mention admin_id', 'data' => array() ], 200);
        }

        
    }

    /* Add Expense */

    public function add(Request $request)
    {
        # expense add...

        $voucher_no = "EXPENSE".time();
        $validator = Validator::make($request->all(), [
            'admin_id' => ['required','exists:users,id'],
            'payment_date' => ['required', 'date', 'date_format:Y-m-d' , 'before_or_equal:'.date('Y-m-d')],
            'amount' => ['required'],   
            'payment_mode' => ['required','in:cheque,neft,cash'],
            'bank_name' => ['required_unless:payment_mode,cash'],
            'chq_utr_no' => ['required_unless:payment_mode,cash'],
            'expense_id' => ['exists:expense,id','required']
        ]);
        // $payment_date = 
        $params = $request->except('_token');

        $expense_at = 'partner';
        $admin_id = $expense_id = 0;
        
        $admin_id = $params['admin_id'];
        $expense_id = $params['expense_id'];
        

        if(!$validator->fails()){
            
            if(!in_array($admin_id,[1,2])){
                return response()->json(['error' => false, 'message' => "You have no authorization to add expense ", 'data' => array() ], 200);
            }


            $payment_id = DB::table('payment')->insertGetId([               
                'admin_id' => $admin_id,
                'payment_for' => 'debit',
                'expense_id' => $expense_id,
                'voucher_no' => $voucher_no,
                'payment_date' => $params['payment_date'],
                'payment_mode' => $params['payment_mode'],
                'payment_in' => ($params['payment_mode'] != 'cash') ? 'bank' : 'cash' ,
                'bank_cash' => ($params['payment_mode'] == 'cash') ? 'cash' : 'bank', 
                'amount' => $params['amount'],
                'bank_name' => !empty($params['bank_name'])?$params['bank_name']:'',
                'chq_utr_no' => !empty($params['chq_utr_no'])?$params['chq_utr_no']:'',
                'narration' => !empty($params['narration'])?$params['narration']:'',
                'created_from' => 'app'
            ]);

            $is_credit = 0; 
            $is_debit = 1;


            /* Add expense in purpose */
            $expense_name = "";
            if(!empty($expense_id)){
                $expense_title = DB::table('expense')->select('title')->find($expense_id);
                $expense_name = $expense_title->title;
            }
            $purpose_description = "expense for ".$expense_at.". ".$expense_name;
            /* ====================== */

            
            DB::table('ledger')->insert([
                'user_type' => $expense_at,
                'admin_id' => $admin_id,
                'transaction_id' => $voucher_no,
                'transaction_amount' => $params['amount'],
                'payment_id' => $payment_id,
                'bank_cash' => ($params['payment_mode'] == 'cash') ? 'cash' : 'bank', 
                'is_credit' => $is_credit,
                'is_debit' => $is_debit,
                'entry_date' => $params['payment_date'],
                'purpose' => 'expense',
                'purpose_description' => $purpose_description
            ]);
        

            
            /* Entry in journal */

            DB::table('journal')->insert([
                'transaction_amount' => $params['amount'],
                'is_credit' => $is_credit,
                'is_debit' => $is_debit,
                'entry_date' => $params['payment_date'],
                'payment_id' => $payment_id,
                'bank_cash' => ($params['payment_mode'] == 'cash') ? 'cash' : 'bank', 
                'purpose' => 'expense',
                'purpose_description' =>  $purpose_description ,
                'purpose_id' => $voucher_no
            ]);

            $successMsg = "Expense added successfully for ".$expense_name."";
            $resultPayment = DB::table('payment')->find($payment_id);

            return response()->json(['error' => false, 'message' => $successMsg, 'data' => array('expense'=>$resultPayment) ], 200);

        } else {
            return response()->json(['status' => 400, 'message' => $validator->errors()->first()],400);
        }

        // dd($params);


    }
}
