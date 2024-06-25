<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\CustomerInterface;
use Illuminate\Support\Str;
use App\Models\PaymentCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AccountingController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth:web');
        $this->middleware(function ($request, $next) {
            $this->id = Auth::user()->id;
            $this->type = Auth::user()->type;
            $this->designation = Auth::user()->designation;
            // dd($this->type);
            if($this->type == 2){
                $userAccesses = userAccesses($this->designation,10);
                if(!$userAccesses){
                    abort(401);
                }
            }

            return $next($request);
        });
    }

    public function add_opening_balance(Request $request,$type='')
    {
        if(!empty($type) && $type == 'partner'){
            $store = DB::table('users')->select('id','name','mobile','email')->where('type',1)->where('status',1)->get();
        }
        $store = DB::table('stores')->select('id','store_name')->where('status', 1)->get();
        return view('admin.accounting.add_openning_balance', compact('store','type'));
    }

    public function save_opening_balance(Request $request)
    {       
        $type_val = $request->type_val;

        // dd($request->all());

        $request->validate([
            'store_id' => 'required',
            'payment_date' => 'required', 
            'payment_in' => 'required', 
            'payment_mode' => 'required', 
            'amount' => 'required_if:payment_in,bank,cash',
            'bank_amount' => 'required_if:payment_in,bank_n_cash',
            'cash_amount' => 'required_if:payment_in,bank_n_cash',
            'payment_for' => 'required'
        ],[
            'store_id.required' => "Please choose store",
            'payment_date.required' => "Please add date of payment",
            'payment_in' => "Please mention way of payment",
            'payment_mode' => "Please mention mode of payment",
            'amount.required_if' => "Please add amount",   
            'bank_amount.required_if' => "Please add bank amount",   
            'cash_amount.required_if' => "Please add cash amount",          
            'payment_for.required' => "Please mention type of payment for"
        ]);    
                
        $is_credit = 0;
        $is_debit = 0;
        if($request->payment_for == 'credit'){
            $is_credit = 1;            
        }
        if($request->payment_for == 'debit'){
            $is_debit = 1;            
        }

        $payment_in = $request->payment_in;

        if(!empty($request->store_id) ){
            # Check exist opening balance for store with payment_in

            $existOB = DB::table('ledger')->select('ledger.*','p.payment_in','p.bank_cash','p.payment_mode')->leftJoin('payment AS p','p.id','ledger.payment_id')->where('ledger.store_id',$request->store_id)->where('ledger.user_type','store')->where('ledger.purpose','opening_balance')->get()->toarray();

            // dd($existOB);

            if(!empty($existOB)){
                // dd($existOB);
                # restrict previous date of existing OB date
                if($request->payment_date < $existOB[0]->entry_date) {
                    $err_msg_date = "Previous date (".date('d/m/Y', strtotime($existOB[0]->entry_date)).") of your existing opening balance is not allowed ";
                    return  redirect()->back()->withErrors(['payment_date'=> $err_msg_date])->withInput();
                }
                
                # check bank and cash entry exists
                foreach($existOB as $ob){
                    if(in_array($request->payment_in, array("bank","bank_n_cash")) &&  $ob->bank_cash == 'bank'){
                        $err_msg_bank = "Already bank entry exists";
                        return  redirect()->back()->withErrors(['payment_in'=> $err_msg_bank])->withInput();
                    }
                    if(in_array($request->payment_in, array("cash","bank_n_cash")) &&  $ob->bank_cash == 'cash'){
                        $err_msg_bank = "Already cash entry exists";
                        return  redirect()->back()->withErrors(['payment_in'=> $err_msg_bank])->withInput();
                    }
                }
                               
                
            }            
            
        }
           
        /* For store opening balance */        

        $store_id = $request->store_id;       
        $user_type = 'store';
        
        # add OB at the top of the existing transaction of the day        

        if($request->payment_in == 'bank_n_cash'){
            if(isset($request->bank_amount)) {
                /* Entry in payment */
                $payment_id = DB::table('payment')->insertGetId([
                    'store_id' => $store_id,
                    'payment_for' => $request->payment_for,
                    'voucher_no' => $request->voucher_no,
                    'payment_date' => $request->payment_date,
                    'payment_in' => $request->payment_in,
                    'bank_cash' => 'bank',
                    'payment_mode' => $request->payment_mode, # cheque or neft
                    'amount' => $request->bank_amount,
                    'chq_utr_no' => $request->chq_utr_no,
                    'bank_name' => $request->bank_name,
                    'narration' => $request->narration     
                ]);
                /* Entry in ledger */
                DB::table('ledger')->insert([
                    'user_type' => $user_type,
                    'store_id' => $store_id,
                    'transaction_id' => $request->voucher_no,
                    'transaction_amount' => $request->bank_amount,
                    'bank_cash' => 'bank',
                    'is_credit' => $is_credit,
                    'is_debit' => $is_debit,
                    'entry_date' => $request->payment_date,
                    'payment_id' => $payment_id,
                    'purpose' => 'opening_balance',
                    'purpose_description' => $user_type." opening balance",
                    'updated_at' => '0000-00-00 00:00:00'
                ]);
                /* Entry in journal */
                DB::table('journal')->insert([
                    'transaction_amount' => $request->bank_amount,
                    'is_credit' => $is_credit,
                    'is_debit' => $is_debit,
                    'entry_date' => $request->payment_date,
                    'payment_id' => $payment_id,
                    'bank_cash' => 'bank',
                    'purpose' => 'opening_balance',
                    'purpose_description' => $user_type." opening balance",
                    'purpose_id' => $request->voucher_no,
                    'updated_at' => '0000-00-00 00:00:00'
                ]);
            }
            if(isset($request->cash_amount)) {
                /* Entry in payment */
                $payment_id = DB::table('payment')->insertGetId([
                    'store_id' => $store_id,
                    'payment_for' => $request->payment_for,
                    'voucher_no' => $request->voucher_no,
                    'payment_date' => $request->payment_date,
                    'payment_in' => $request->payment_in,
                    'bank_cash' => 'cash',
                    'payment_mode' => 'cash', # cheque or neft or cash
                    'amount' => $request->cash_amount,
                    'chq_utr_no' => '',
                    'bank_name' => '',
                    'narration' => $request->narration
                ]);
                /* Entry in ledger */
                DB::table('ledger')->insert([
                    'user_type' => $user_type,
                    'store_id' => $store_id,
                    'transaction_id' => $request->voucher_no,
                    'transaction_amount' => $request->cash_amount,
                    'is_credit' => $is_credit,
                    'is_debit' => $is_debit,
                    'entry_date' => $request->payment_date,
                    'payment_id' => $payment_id,
                    'bank_cash' => 'cash',
                    'purpose' => 'opening_balance',
                    'purpose_description' => $user_type." opening balance",
                    'updated_at' => '0000-00-00 00:00:00'
                ]);
                /* Entry in journal */
                DB::table('journal')->insert([
                    'transaction_amount' => $request->cash_amount,
                    'is_credit' => $is_credit,
                    'is_debit' => $is_debit,
                    'entry_date' => $request->payment_date,
                    'payment_id' => $payment_id,
                    'bank_cash' => 'cash',
                    'purpose' => 'opening_balance',
                    'purpose_description' => $user_type." opening balance",
                    'purpose_id' => $request->voucher_no,
                    'updated_at' => '0000-00-00 00:00:00'
                ]);
            }
        } else {
            /* Entry in payment */
            
            $payment_id = DB::table('payment')->insertGetId([
                'store_id' => $store_id,
                'payment_for' => $request->payment_for,
                'voucher_no' => $request->voucher_no,
                'payment_date' => $request->payment_date,
                'payment_in' => $request->payment_in,    
                'bank_cash' => ($request->payment_in != 'bank') ? 'cash':  $request->payment_in,            
                'payment_mode' => $request->payment_mode,
                'amount' => $request->amount,
                'chq_utr_no' => $request->chq_utr_no,
                'bank_name' => $request->bank_name,
                'narration' => $request->narration 
            ]);
            /* Entry in ledger */
            DB::table('ledger')->insert([
                'user_type' => $user_type,
                'store_id' => $store_id,
                'transaction_id' => $request->voucher_no,
                'transaction_amount' => $request->amount,
                'is_credit' => $is_credit,
                'is_debit' => $is_debit,
                'entry_date' => $request->payment_date,
                'payment_id' => $payment_id,
                'bank_cash' => ($request->payment_in != 'bank') ? 'cash':  $request->payment_in,  
                'purpose' => 'opening_balance',
                'purpose_description' => $user_type." opening balance",
                'updated_at' => '0000-00-00 00:00:00'
            ]);
            /* Entry in journal */
            DB::table('journal')->insert([
                'transaction_amount' => $request->amount,
                'is_credit' => $is_credit,
                'is_debit' => $is_debit,
                'entry_date' => $request->payment_date,
                'bank_cash' => ($request->payment_in != 'bank') ? 'cash':  $request->payment_in,  
                'purpose' => 'opening_balance',
                'purpose_description' => $user_type." opening balance",
                'purpose_id' => $request->voucher_no,
                'payment_id' => $payment_id,
                'updated_at' => '0000-00-00 00:00:00'
            ]);
        }               

        Session::flash('message', 'Opening balance for customer added successfully'); 
        return redirect()->route('admin.accounting.listopeningbalance');
        
        
    }

    public function save_opening_balance_partner(Request $request)
    {
        # save opening balance for partner...

        $request->validate([
            'admin_id' => 'required',
            'payment_date' => 'required', 
            'payment_in' => 'required', 
            'payment_mode' => 'required', 
            'amount' => 'required_if:payment_in,bank,cash',
            'bank_amount' => 'required_if:payment_in,bank_n_cash',
            'cash_amount' => 'required_if:payment_in,bank_n_cash',
            'payment_for' => 'required'
        ],[
            'admin_id.required' => "Please choose partner",
            'payment_date.required' => "Please add date of payment",
            'payment_in' => "Please mention way of payment",
            'payment_mode' => "Please mention mode of payment",
            'amount.required_if' => "Please add amount",  
            'bank_amount.required_if' => "Please add bank amount",   
            'cash_amount.required_if' => "Please add cash amount",        
            'payment_for.required' => "Please mention type of payment for"
        ]);

        $is_credit = 0;
        $is_debit = 0;
        if($request->payment_for == 'credit'){
            $is_credit = 1;            
        }
        if($request->payment_for == 'debit'){
            $is_debit = 1;            
        }

        $payment_in = $request->payment_in;

        if(!empty($request->admin_id) ){
            /* Check exist opening balance for partner with payment_in */

            $existOB = DB::table('ledger')->select('ledger.*','p.payment_in','p.bank_cash','p.payment_mode')->leftJoin('payment AS p','p.id','ledger.payment_id')->where('ledger.admin_id',$request->admin_id)->where('ledger.user_type','partner')->where('ledger.purpose','opening_balance')->get()->toarray();

            // dd($existOB);

            if(!empty($existOB)){
                // dd($existOB);
                # restrict previous date of existing OB date
                if($request->payment_date < $existOB[0]->entry_date) {
                    $err_msg_date = "Previous date (".date('d/m/Y', strtotime($existOB[0]->entry_date)).") of your existing opening balance is not allowed ";
                    return  redirect()->back()->withErrors(['payment_date'=> $err_msg_date])->withInput();
                }
                
                # check bank exists only
                foreach($existOB as $ob){
                    if(in_array($request->payment_in, array("bank","bank_n_cash")) &&  $ob->bank_cash == 'bank'){
                        $err_msg_bank = "Already bank entry exists";
                        return  redirect()->back()->withErrors(['payment_in'=> $err_msg_bank])->withInput();
                    }
                    if(in_array($request->payment_in, array("cash","bank_n_cash")) &&  $ob->bank_cash == 'cash'){
                        $err_msg_bank = "Already cash entry exists";
                        return  redirect()->back()->withErrors(['payment_in'=> $err_msg_bank])->withInput();
                    }
                }
                                
            }  
            
           
        }
          
        /* For partner opening balance */        

        $admin_id = $request->admin_id;        
        $user_type = 'partner';

        if($request->payment_in == 'bank_n_cash'){
            if(isset($request->bank_amount)) {
                /* Entry in payment */
                $payment_id = DB::table('payment')->insertGetId([
                    'admin_id' => $admin_id,
                    'payment_for' => $request->payment_for,
                    'voucher_no' => $request->voucher_no,
                    'payment_date' => $request->payment_date,
                    'payment_in' => $request->payment_in,
                    'bank_cash' => 'bank',
                    'payment_mode' => $request->payment_mode, # cheque or neft
                    'amount' => $request->bank_amount,
                    'chq_utr_no' => $request->chq_utr_no,
                    'bank_name' => $request->bank_name,
                    'narration' => $request->narration     
                ]);
                /* Entry in ledger */
                DB::table('ledger')->insert([
                    'user_type' => $user_type,
                    'admin_id' => $admin_id,
                    'transaction_id' => $request->voucher_no,
                    'transaction_amount' => $request->bank_amount,
                    'is_credit' => $is_credit,
                    'is_debit' => $is_debit,
                    'entry_date' => $request->payment_date,
                    'payment_id' => $payment_id,
                    'bank_cash' => 'bank',
                    'purpose' => 'opening_balance',
                    'purpose_description' => $user_type." opening balance",
                    'updated_at' => '0000-00-00 00:00:00'
                ]);
                /* Entry in journal */
                DB::table('journal')->insert([
                    'transaction_amount' => $request->bank_amount,
                    'is_credit' => $is_credit,
                    'is_debit' => $is_debit,
                    'entry_date' => $request->payment_date,
                    'payment_id' => $payment_id,
                    'bank_cash' => 'bank',
                    'purpose' => 'opening_balance',
                    'purpose_description' => $user_type." opening balance",
                    'purpose_id' => $request->voucher_no,
                    'updated_at' => '0000-00-00 00:00:00'
                ]);
            }
            if(isset($request->cash_amount)) {
                /* Entry in payment */
                $payment_id = DB::table('payment')->insertGetId([
                    'admin_id' => $admin_id,
                    'payment_for' => $request->payment_for,
                    'voucher_no' => $request->voucher_no,
                    'payment_date' => $request->payment_date,
                    'payment_in' => $request->payment_in,
                    'bank_cash' => 'cash',
                    'payment_mode' => 'cash', # cheque or neft or cash
                    'amount' => $request->cash_amount,
                    'chq_utr_no' => '',
                    'bank_name' => '',
                    'narration' => $request->narration
                ]);
                /* Entry in ledger */
                DB::table('ledger')->insert([
                    'user_type' => $user_type,
                    'admin_id' => $admin_id,
                    'transaction_id' => $request->voucher_no,
                    'transaction_amount' => $request->cash_amount,
                    'is_credit' => $is_credit,
                    'is_debit' => $is_debit,
                    'entry_date' => $request->payment_date,
                    'payment_id' => $payment_id,
                    'bank_cash' => 'cash',
                    'purpose' => 'opening_balance',
                    'purpose_description' => $user_type." opening balance",
                    'updated_at' => '0000-00-00 00:00:00'
                ]);
                /* Entry in journal */
                DB::table('journal')->insert([
                    'transaction_amount' => $request->cash_amount,
                    'is_credit' => $is_credit,
                    'is_debit' => $is_debit,
                    'entry_date' => $request->payment_date,
                    'payment_id' => $payment_id,
                    'bank_cash' => 'cash',
                    'purpose' => 'opening_balance',
                    'purpose_description' => $user_type." opening balance",
                    'purpose_id' => $request->voucher_no,
                    'updated_at' => '0000-00-00 00:00:00'
                ]);
            }
        } else {
            /* Entry in payment */
            $payment_id = DB::table('payment')->insertGetId([
                'admin_id' => $admin_id,
                'payment_for' => $request->payment_for,
                'voucher_no' => $request->voucher_no,
                'payment_date' => $request->payment_date,
                'payment_in' => $request->payment_in,
                'bank_cash' => ($request->payment_in != 'bank') ? 'cash' : $request->payment_in,
                'payment_mode' => $request->payment_mode,
                'amount' => $request->amount,
                'chq_utr_no' => $request->chq_utr_no,
                'bank_name' => $request->bank_name,
                'narration' => $request->narration 
            ]);
            /* Entry in ledger */
            DB::table('ledger')->insert([
                'user_type' => $user_type,
                'admin_id' => $admin_id,
                'transaction_id' => $request->voucher_no,
                'transaction_amount' => $request->amount,
                'is_credit' => $is_credit,
                'is_debit' => $is_debit,
                'entry_date' => $request->payment_date,
                'payment_id' => $payment_id,
                'bank_cash' => ($request->payment_in != 'bank') ? 'cash' : $request->payment_in,
                'purpose' => 'opening_balance',
                'purpose_description' => $user_type." opening balance",
                'updated_at' => '0000-00-00 00:00:00'
            ]);
            /* Entry in journal */
            DB::table('journal')->insert([
                'transaction_amount' => $request->amount,
                'is_credit' => $is_credit,
                'is_debit' => $is_debit,
                'entry_date' => $request->payment_date,
                'bank_cash' => ($request->payment_in != 'bank') ? 'cash' : $request->payment_in,
                'purpose' => 'opening_balance',
                'purpose_description' => $user_type." opening balance",
                'purpose_id' => $request->voucher_no,
                'payment_id' => $payment_id,
                'updated_at' => '0000-00-00 00:00:00'
            ]);
        }               

        Session::flash('message', 'Opening balance for partner added successfully'); 
        
        return redirect()->route('admin.accounting.add-opening-balance','partner');
        


    }

    public function add_expenses(Request $request)
    {
        
        return view('admin.accounting.add_expense');
    }

    public function edit_expenses($id,Request $request)
    {
        # edit expense form...
        $payment = DB::table('payment')->find($id);
        // dd($payment);
        return view('admin.accounting.edit_expense', compact('id','payment'));
    }

    public function save_expenses(Request $request)
    {
        // echo $request->bank_name; die;
        // dd($request->all());
        $store_id = !empty($request->store_id)?$request->store_id:'';
        $staff_id = !empty($request->staff_id)?$request->staff_id:'';
        $admin_id = !empty($request->admin_id)?$request->admin_id:'';
        $supplier_id = !empty($request->supplier_id)?$request->supplier_id:'';
        $user_type = !empty($request->user_type)?$request->user_type:'';
        $expense_id = !empty($request->expense_id)?$request->expense_id:'';

        if($user_type != 'miscellaneous'){
            $request->validate([
                'payment_date' => 'required', 
                'payment_mode' => 'required', 
                'amount' => 'required', 
                'user_type' => 'required', 
                // 'user' => 'required', 
                'user_id' => 'required',
                'user_name' => 'required',
                'expense_id' => 'required'
            ],[
                'payment_date.required' => "Please add date of payment",
                'payment_mode' => "Please mention mode of payment",
                'amount.required' => "Please add amount",
                'user_type.required' => "Please mention expense at",
                'user_id.required' => "Please specify which user",
                'expense_id.required' => "Please add expense type"
            ]);
        }else{
            $request->validate([
                'payment_date' => 'required', 
                'payment_mode' => 'required', 
                'amount' => 'required', 
                'user_type' => 'required'                
            ],[
                'payment_date.required' => "Please add date of payment",
                'payment_mode' => "Please mention mode of payment",
                'amount.required' => "Please add amount",
                'user_type.required' => "Please mention expense at",                
            ]);
        }

        $paymentData = array(            
            'payment_for' => 'debit',
            'voucher_no' => $request->voucher_no,
            'payment_date' => $request->payment_date,
            'payment_mode' => $request->payment_mode,
            'payment_in' => ($request->payment_mode != 'cash') ? 'bank' : 'cash' ,
            'bank_cash' => ($request->payment_mode == 'cash') ? 'cash' : 'bank', 
            'amount' => $request->amount,
            'bank_name' => $request->bank_name,
            'chq_utr_no' => $request->chq_utr_no,
            'narration' => $request->narration
        );        

        if($user_type == 'miscellaneous'){

        } else {
            if($user_type == 'staff'){
                $paymentStaff = array('staff_id' => $staff_id);
                $paymentData = array_merge($paymentData,$paymentStaff);
            } else if ($user_type == 'store'){
                $paymentStore = array('store_id' => $store_id);
                $paymentData = array_merge($paymentData,$paymentStore);
            } else if ($user_type == 'partner'){
                $paymentAdmin = array('admin_id' => $admin_id);
                $paymentData = array_merge($paymentData,$paymentAdmin);
            } else if ($user_type == 'supplier'){
                $paymentSupplier = array('supplier_id' => $supplier_id);
                $paymentData = array_merge($paymentData,$paymentSupplier);
            }
        }
        
        if(!empty($expense_id)){
            $paymentExpense = array('expense_id' => $expense_id,);
            $paymentData = array_merge($paymentData,$paymentExpense);
        }

        $payment_id = DB::table('payment')->insertGetId($paymentData);
        
        $is_credit = 0; 
        $is_debit = 1;        

        /* Add expense in purpose */
        $expense_name = "";
        if(!empty($expense_id)){
            $expense_name = !empty($request->expense_name)?$request->expense_name:'';
        }
        $purpose_description = "expense for ".$user_type.". ".$expense_name;
        /* ====================== */

        if($user_type != 'miscellaneous'){
            $ledgerData = array(
                'user_type' => $user_type,
                'transaction_id' => $request->voucher_no,
                'transaction_amount' => $request->amount,
                'payment_id' => $payment_id,
                'bank_cash' => ($request->payment_mode == 'cash') ? 'cash' : 'bank', 
                'is_credit' => $is_credit,
                'is_debit' => $is_debit,
                'entry_date' => $request->payment_date,
                'purpose' => 'expense',
                'purpose_description' => $purpose_description
            );
            if($user_type == 'staff'){
                $ledgerStaff = array('staff_id' => $staff_id);
                $ledgerData = array_merge($ledgerData,$ledgerStaff);
            } else if ($user_type == 'store'){
                $ledgerStore = array('store_id' => $store_id);
                $ledgerData = array_merge($ledgerData,$ledgerStore);
            } else if ($user_type == 'partner'){
                $ledgerAdmin = array('admin_id' => $admin_id);
                $ledgerData = array_merge($ledgerData,$ledgerAdmin);
            } else if ($user_type == 'supplier'){
                $ledgerSupplier = array('supplier_id' => $supplier_id);
                $ledgerData = array_merge($ledgerData,$ledgerSupplier);
            }

            // dd($ledgerData);
            
            DB::table('ledger')->insert($ledgerData);
        }
        

        /* Entry in journal */

        DB::table('journal')->insert([
            'transaction_amount' => $request->amount,
            'is_credit' => $is_credit,
            'is_debit' => $is_debit,
            'entry_date' => $request->payment_date,
            'payment_id' => $payment_id,
            'bank_cash' => ($request->payment_mode == 'cash') ? 'cash' : 'bank', 
            'purpose' => 'expense',
            'purpose_description' =>  $purpose_description ,
            'purpose_id' => $request->voucher_no
        ]);

        /* for partner withdrawl */

        $withdrawls_id = !empty($request->withdrawls_id)?$request->withdrawls_id:'';

        DB::table('withdrawls')->where('id',$withdrawls_id)->update(['is_disbursed' => 1]);

        
        if(!empty($withdrawls_id)){
            $successMsg = "Withdrawl disbursed for partner successfully";
            Session::flash('message', $successMsg); 
            return redirect()->route('admin.revenue.withdrawls');
        } else {
            $successMsg = "Expense added successfully for ".$user_type."";
            Session::flash('message', $successMsg); 
            return redirect()->route('admin.accounting.add_expenses');
        }

        
        
        


    }

    public function update_expense($id,Request $request)
    {
        # update expense...
        $request->validate([
            'amount' => 'required',
            'payment_in' => 'required',
            'chq_utr_no' => 'required_if:payment_in,bank',
            'bank_name' => 'required_if:payment_in,bank'
        ]);

        // dd($request->all());

        $params = $request->except('_token');
        $params['updated_at'] = date('Y-m-d H:i:s');
        unset($params['bank_name_hidden']);
        if($params['payment_in'] == 'cash'){
            $params['bank_name'] = '';
            $params['chq_utr_no'] = '';
        }
        // dd($params);
        DB::table('payment')->where('id',$id)->update($params);
        DB::table('ledger')->where('payment_id',$id)->update([
            'bank_cash' => $params['bank_cash'],
            'entry_date' => $params['payment_date'],
            'transaction_amount' => $params['amount'],
            'updated_at' => $params['updated_at']
        ]);
        DB::table('journal')->where('payment_id',$id)->update([
            'bank_cash' => $params['bank_cash'],
            'entry_date' => $params['payment_date'],
            'transaction_amount' => $params['amount'],
            'updated_at' => $params['updated_at']
        ]);

        Session::flash('message', "Expense updated successfully"); 
        return redirect()->route('admin.accounting.edit_expenses',$id);
    }

    public function add_payment_receipt($paymentCollectionId=0,Request $request)
    {
        $payment_collection = array();
        
        $payment_collection = PaymentCollection::select('payment_collections.*','stores.store_name','users.name AS staff_name',)->leftJoin('stores','stores.id','payment_collections.store_id')->leftJoin('users','users.id','payment_collections.user_id')->find($paymentCollectionId);

        $stores = DB::table('stores')->orderBy('store_name')->get();

        
        return view('admin.accounting.add_payment_receipt', compact('paymentCollectionId','payment_collection','stores'));        
        
    }

    public function save_payment_receipt(Request $request)
    {
        
        $request->validate([
            // 'payment_collection_id' => 'required',
            'store_id' => 'required',
            'staff_id' => 'required',
            'payment_date' => 'required', 
            'payment_mode' => 'required', 
            'amount' => 'required'
            
        ],[    
            'store_id.required' => "Please add store",        
            'payment_date.required' => "Please add date of payment",
            'payment_mode' => "Please mention mode of payment",
            'amount.required' => "Please add amount"
        ]);

        $store_id = $request->store_id;
        $staff_id = !empty($request->staff_id)?$request->staff_id:'';
        $admin_id = '';
        if(in_array($staff_id,[1,2])){
            $admin_id = $staff_id;
            $staff_id = '';
        }
        $user_type = 'store';
        

        if(empty($request->payment_collection_id)){
            // echo $request->store_id;
            $check_store_unpaid_invoices = DB::table('invoice')->where('store_id', $request->store_id)->where('is_paid', 0)->get()->toarray();

            if(empty($check_store_unpaid_invoices)){
                return  redirect()->back()->withErrors(['amount'=> "No unpaid invoice found of the store" ])->withInput();
            }

            $check_outstanding_amount = DB::table('invoice')->where('store_id',$request->store_id)->where('is_paid',0)->sum('required_payment_amount');

            $check_not_receipt_payment_amount = DB::table('payment_collections')->where('store_id',$request->store_id)->where('is_ledger_added',0)->first();

            if($request->amount > $check_outstanding_amount){
                return  redirect()->back()->withErrors(['amount' => 'Please decrease your amount value. Unpaid outstanding amount is '.$check_outstanding_amount ])->withInput();
            }

        }
        
        $paymentData = array(            
            'payment_for' => 'credit',
            'voucher_no' => $request->voucher_no,
            'payment_date' => $request->payment_date,
            'payment_mode' => $request->payment_mode,
            'payment_in' => ($request->payment_mode != 'cash') ? 'bank' : 'cash' ,
            'bank_cash' => ($request->payment_mode == 'cash') ? 'cash' : 'bank', 
            'amount' => $request->amount,
            'chq_utr_no' => !empty($request->chq_utr_no)?$request->chq_utr_no:'',
            'bank_name' => !empty($request->bank_name)?$request->bank_name:''
        );        

        
        if(!empty($staff_id)){
            $paymentStaff = array('staff_id' => $staff_id);
            $paymentData = array_merge($paymentData,$paymentStaff);
        } 
        if (!empty($store_id)){
            $paymentStore = array('store_id' => $store_id);
            $paymentData = array_merge($paymentData,$paymentStore);
        } 
        if (!empty($admin_id)){
            $paymentAdmin = array('admin_id' => $admin_id);
            $paymentData = array_merge($paymentData,$paymentAdmin);
        }
       
        $payment_id = DB::table('payment')->insertGetId($paymentData);
        
        $is_credit = 1;        
        $is_debit = 0;

        
        $ledgerData = array(
            'user_type' => $user_type,
            'transaction_id' => $request->voucher_no,
            'transaction_amount' => $request->amount,
            'payment_id' => $payment_id,
            'bank_cash' => ($request->payment_mode == 'cash') ? 'cash' : 'bank',
            'is_credit' => $is_credit,
            'is_debit' => $is_debit,
            'entry_date' => $request->payment_date,
            'purpose' => 'payment_receipt',
            'purpose_description' => 'store payment receipt from sales invoice'
        );
        if(!empty($staff_id)){
            $ledgerStaff = array('staff_id' => $staff_id);
            $ledgerData = array_merge($ledgerData,$ledgerStaff);
        } 
        if (!empty($store_id)){
            $ledgerStore = array('store_id' => $store_id);
            $ledgerData = array_merge($ledgerData,$ledgerStore);
        } 
        if (!empty($admin_id)){
            $ledgerAdmin = array('admin_id' => $admin_id);
            $ledgerData = array_merge($ledgerData,$ledgerAdmin);
        } 
        if (!empty($supplier_id)){
            $ledgerSupplier = array('supplier_id' => $supplier_id);
            $ledgerData = array_merge($ledgerData,$ledgerSupplier);
        }
                
        DB::table('ledger')->insert($ledgerData);

        /* Entry in journal */

        DB::table('journal')->insert([
            'transaction_amount' => $request->amount,
            'is_credit' => $is_credit,
            'is_debit' => $is_debit,
            'entry_date' => $request->payment_date,
            'payment_id' => $payment_id,
            'bank_cash' => ($request->payment_mode == 'cash') ? 'cash' : 'bank',
            'purpose' => 'payment_receipt',
            'purpose_description' => 'store payment receipt from sales invoice',
            'purpose_id' => $request->voucher_no
        ]);

        if(!empty($request->payment_collection_id)){
            DB::table('payment_collections')->where('id',$request->payment_collection_id)->update([
                'is_ledger_added' => 1,
                'vouchar_no' => $request->voucher_no,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } 
        

        $this->invoicePayments($request->voucher_no,$request->amount,$store_id);
        if(!empty($staff_id)){            
            $this->staffCommission($request->voucher_no);
        }        

        Session::flash('message', 'Payment receipt added successfully'); 
        if(!empty($request->payment_collection_id)){
            return redirect()->route('admin.paymentcollection.index');
        } else {
            return redirect()->route('admin.accounting.add_payment_receipt');
        }
        

    }

    private function invoicePayments($voucher_no,$payment_amount,$store_id)
    {
        // die('voucher_no : '.$voucher_no.'<br/>payment_amount : '.$payment_amount.'<br/>store_id : '.$store_id.' ');
        // DB::enableQueryLog();

        $check_invoice_payments = DB::table('invoice_payments')->where('voucher_no','=',$voucher_no)->get()->toarray();

        if(empty($check_invoice_payments)){
            
            // die('No invoice payments found');
            $amount_after_settlement = $payment_amount;
            /* Check store unpaid invoices */
            $invoice = DB::table('invoice')->where('store_id',$store_id)->where('is_paid',0)->get();

            $sum_inv_amount = 0;
            foreach($invoice as $inv){
                
                $amount = $inv->required_payment_amount;
                $sum_inv_amount += $amount;
                if($amount_after_settlement>$amount && $amount_after_settlement>0){
                    $amount_after_settlement=$amount_after_settlement-$amount;
                    
                    DB::table('invoice')->where('id',$inv->id)->update([
                        'required_payment_amount'=>'',
                        'payment_status' => 2,
                        'is_paid'=>1
                    ]);

                    DB::table('invoice_payments')->insert([
                        'invoice_id' => $inv->id,
                        'invoice_no' => $inv->invoice_no,
                        'voucher_no' => $voucher_no,
                        'invoice_amount' => $inv->net_price,
                        'vouchar_amount' => $payment_amount,
                        'paid_amount' => $amount,
                        'rest_amount' => ''
                    ]);
                }else if($amount_after_settlement<$amount && $amount_after_settlement>0){
                    
                    $rest_payment_amount = ($amount - $amount_after_settlement);
                    
                    DB::table('invoice')->where('id',$inv->id)->update([
                        'required_payment_amount'=>$rest_payment_amount,
                        'payment_status' => 1,
                        'is_paid'=>0
                    ]);
                    DB::table('invoice_payments')->insert([
                        'invoice_id' => $inv->id,
                        'invoice_no' => $inv->invoice_no,
                        'voucher_no' => $voucher_no,
                        'invoice_amount' => $inv->net_price,
                        'vouchar_amount' => $payment_amount,
                        'paid_amount' => $amount_after_settlement,
                        'rest_amount' => $rest_payment_amount
                    ]);

                    $amount_after_settlement = 0;
                                        
                }else if($amount_after_settlement==0){
                    
                }
            }
            
            
        }else{
            
        }


    }

    private function staffCommission($voucher_no)
    {
        # Get dynamic percentage value from app settings
        $app_settings = DB::table('app_settings')->find(1);
        $staff_payment_incentive = $app_settings->staff_payment_incentive;        
        $order_collector_commission = $app_settings->order_collector_commission;
        $payment_collector_commission = $app_settings->payment_collector_commission;

        /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

        $payment = DB::table('payment')->where('voucher_no',$voucher_no)->first();
        $payment_collector_id = $payment->staff_id;
        $payment_date = $payment->payment_date;
        
        # get full done invoice payments

        $paid_invoices = DB::table('invoice_payments AS ip')->select('ip.*','invoice.order_id','orders.user_id')->leftJoin('invoice', 'invoice.id','ip.invoice_id')->leftJoin('orders', 'orders.id','invoice.order_id')->where('ip.rest_amount', 0)->where('ip.voucher_no',$voucher_no)->where('ip.is_commisionable', 0)->get()->toarray();

        if(!empty($paid_invoices)){
            foreach($paid_invoices as $inv){
                $order_creator_id = $inv->user_id;
                $paid_amount = $inv->paid_amount;
    
                $commission_amount = getPercentageVal($staff_payment_incentive,$paid_amount);
                $commission_amount = number_format((float)$commission_amount, 2, '.', '');
    
                // echo "commission_amount : ".$commission_amount."<br/>";
                $order_collector_commission_amount = getPercentageVal($order_collector_commission,$commission_amount);
                $order_collector_commission_amount = number_format((float)$order_collector_commission_amount, 2, '.', '');
    
                $payment_collector_commission_amount = getPercentageVal($payment_collector_commission,$commission_amount);
                $payment_collector_commission_amount = number_format((float)$payment_collector_commission_amount, 2, '.', '');
    
                /* +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
    
                /* Order creator commission entry */
                # staff_commision entry
                DB::table('staff_commision')->insert([
                    'staff_id' => $order_creator_id,
                    'paid_as' => 'order_creator',
                    'vouchar_no' => $voucher_no,
                    'order_id' => $inv->order_id,
                    'invoice_id' => $inv->invoice_id,
                    'invoice_payment_id' => $inv->id,
                    'commission_percentage_val' => $order_collector_commission,
                    'commission_amount' => $order_collector_commission_amount                
                ]);

                # ledger entry  
                $order_creator_ledger_transaction_no = time();
                DB::table('ledger')->insert([
                    'user_type' => 'staff',
                    'staff_id' => $order_creator_id,
                    'transaction_id' => $order_creator_ledger_transaction_no,
                    'transaction_amount' => $order_collector_commission_amount,
                    'is_credit' => 1,
                    'entry_date' => $payment_date,
                    'purpose' => 'payment_collection_commission',
                    'purpose_description' => 'Sales order payment commission for order creator'
                ]);
                
                /* +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
    
                /* Payment collector commission entry */
    
                DB::table('staff_commision')->insert([
                    'staff_id' => $payment_collector_id,
                    'paid_as' => 'payment_collector',
                    'vouchar_no' => $voucher_no,
                    'order_id' => $inv->order_id,
                    'invoice_id' => $inv->invoice_id,
                    'invoice_payment_id' => $inv->id,
                    'commission_percentage_val' => $payment_collector_commission,
                    'commission_amount' => $payment_collector_commission_amount                
                ]);

                # ledger entry                
                $payment_collector_ledger_transaction_no = time();
                DB::table('ledger')->insert([
                    'user_type' => 'staff',
                    'staff_id' => $payment_collector_id,
                    'transaction_id' => $payment_collector_ledger_transaction_no,
                    'transaction_amount' => $payment_collector_commission_amount,
                    'is_credit' => 1,
                    'entry_date' => $payment_date,
                    'purpose' => 'payment_collection_commission',
                    'purpose_description' => 'Sales order payment commission for payment collector'
                ]);
                    
                /* +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
    
                /* Make invice payment staff commissionable */
    
                DB::table('invoice_payments')->where('id',$inv->id)->update([
                    'is_commisionable' => 1,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
    
                /* +++++++++++++++++++++++++++++++++++++++++++++++++++++ */
    
            }
        }
        
    }

    public function listopeningbalance(Request $request)
    {
        # code...

        $data = DB::table('ledger AS l')->select('l.*','s.store_name','s.bussiness_name','s.contact','s.whatsapp','p.payment_mode','p.bank_cash','p.payment_for','p.payment_in','p.bank_name','p.narration')->leftJoin('stores AS s','s.id','l.store_id')->leftJoin('payment AS p','p.id','l.payment_id')->where('l.purpose','opening_balance')->where('l.user_type','store')->orderBy('l.id','desc')->paginate(20);
        // dd($data);
        return view('admin.accounting.list_openning_balance', compact('data'));
    }

    public function deleteopeningbalance($id)
    {
        $ledger = DB::table('ledger')->find($id);
        $payment_id = $ledger->payment_id;
        DB::table('ledger')->where('id',$id)->delete();  # delete ledger record
        DB::table('payment')->where('id',$payment_id)->delete();  # delete payment record
        DB::table('journal')->where('payment_id',$payment_id)->delete();  # delete journal record

        Session::flash('message', 'Opening balance deleted successfully'); 
        return redirect()->route('admin.accounting.listopeningbalance');
    }

    public function add_expense_partner_withdrawls($withdrawls_id=0,Request $request)
    {
        # expense form for partner withdrawl amount
        
        $withdrawls = DB::table('withdrawls AS w')->select('w.*','a.name','a.email')->leftJoin('users AS u','u.id','w.admin_id')->where('w.id',$withdrawls_id)->first();
        
        if(!empty($withdrawls)){
            // dd($withdrawls);
            $expense_partner_withdrawl = DB::table('expense')->where('slug', 'partner-withdrawl')->first();
            $expense_id = $expense_partner_withdrawl->id;
            return view('admin.accounting.add_withdrawl', compact('withdrawls','expense_id'));
        } else {
            return redirect()->route('admin.revenue.withdrawls');
        }
        
    }
}
