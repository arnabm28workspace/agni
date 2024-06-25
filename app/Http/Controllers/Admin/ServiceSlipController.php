<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class ServiceSlipController extends Controller
{    
    public function __construct(Request $request)
    {
        $this->middleware('auth:web');
        $this->middleware(function ($request, $next) {
            $this->type = Auth::user()->type;
            if($this->type == 2){               
                abort(401);                
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        # code...
        $term = !empty($request->term)?$request->term:'';
        $data = DB::table('service_slip AS ss')->select('ss.*','s.store_name','s.bussiness_name','s.contact');
        if(!empty($term)){
            $data = $data->where(function($query) use ($term){
                $query->where('ss.item_name', 'LIKE', '%'.$term.'%')->orWhere('s.store_name', 'LIKE', '%'.$term.'%')->orWhere('s.bussiness_name','LIKE', '%'.$term.'%')->orWhere('s.contact','LIKE', '%'.$term.'%');
            });
        }
        
        $data = $data->leftJoin('stores AS s','s.id','ss.store_id')->orderBy('ss.id','desc')->paginate(20);
        $total = DB::table('service_slip')->count();
        return view('admin.serviceslip.index', compact('data','term','total'));
    }

    
    public function add(Request $request)
    {
        # code...
        return view('admin.serviceslip.add');
    }

    public function save(Request $request)
    {
        # code...

        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'item_name' => 'required',
            'entry_date' => 'required|date|before_or_equal:entry_date',
            'amount' => 'required|numeric'
        ]);

        $params = $request->except('_token');
        // dd($params);
        $id = DB::table('service_slip')->insertGetId($params);    
        /* Add to payment */
        
        $paymentData = array(
            'store_id' => $params['store_id'],
            'payment_for' => 'debit',
            'payment_in' => 'cash',
            'bank_cash' => 'cash',
            'service_slip_id' => $id,
            'voucher_no' => $params['voucher_no'],
            'payment_date' => $params['entry_date'],
            'amount' => $params['amount'],
            'narration' => $params['narration'],
            'is_gst' => 0
        );
        $payment_id = DB::table('payment')->insertGetId($paymentData);  
        $ledgerData = array(
            'user_type' => 'store',
            'store_id' => $params['store_id'],
            'transaction_id' => $params['voucher_no'],
            'payment_id' => $payment_id,
            'bank_cash' => 'cash',
            'transaction_amount' => $params['amount'],
            'is_debit' => 1,
            'entry_date' => $params['entry_date'],
            'purpose' => 'service_slip',
            'purpose_description' => $params['item_name'],
            'is_gst' => 0
        );
        DB::table('ledger')->insert($ledgerData);
        $journalData = array(
            'transaction_amount' => $params['amount'],
            'payment_id' => $payment_id,
            'is_credit' => 1,
            'bank_cash' => 'cash',
            'purpose' => 'service_slip',
            'purpose_description' =>  $params['item_name'],
            'purpose_id' => $params['voucher_no'],
            'entry_date' => $params['entry_date'],
            'is_gst' => 0
        );
        DB::table('journal')->insert($journalData);
        Session::flash('message', 'Service slip saved successfully'); 
        return redirect()->route('admin.service-slip.index',$params);

    }

    public function pdf($slip_id,Request $request)
    {
        # pdf for download...     
        $service_slip = DB::table('service_slip AS ss')->select('ss.*','s.store_name','s.bussiness_name','s.contact')->leftJoin('stores AS s','s.id','ss.store_id')->where('ss.id',$slip_id)->first();
        // dd($service_slip);
        return view('admin.serviceslip.pdf', compact('service_slip'));
    }
}
