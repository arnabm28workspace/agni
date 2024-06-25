<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use DateTime;
use App\Models\Stock;
use App\Models\StockBox;
use App\Models\StockProduct;
use App\Models\PurchaseOrderBox;

class TestController extends Controller
{
    //
    public function save(Request $request)
    {
        $product_id = 1; 
        $ids = array();

        $stock_products = StockProduct::where('product_id',$product_id)->get();
        if(!empty($stock_products)){
            foreach($stock_products as $stock){
                $ids[] = $stock->stock_id;
            }
        }

        $data = Stock::select('*');
        
        if(!empty($ids)){
            $data = $data->whereIn('id',$ids);
        }

        $data = $data->get();

        dd($data);

    }

    public function generateStaffSalary(Request $request)
    {
        # test staff salary...
        $entry_date = !empty($request->entry_date)?$request->entry_date:'';
        if(!empty($entry_date)){
            $staff = DB::table('users')->select('id','name','monthly_salary','daily_salary')->where('type', 2)->where('status', 1)->get();

            if(!empty($staff)){
                foreach($staff as $user){
                    /* Salary Generation */
                    
                    $checkExistSalaryDayLedger = DB::table('ledger')->where('staff_id',$user->id)->where('purpose','salary')->where('entry_date', $entry_date)->first();
                    if(empty($checkExistSalaryDayLedger)){
                        $transaction_id = "SAL".$user->id."".date('Ymd').time();
                        $user->salary_id = $transaction_id;
                        DB::table('ledger')->insert([
                            'user_type' => 'staff',
                            'staff_id' => $user->id,
                            'transaction_id' => $transaction_id,
                            'transaction_amount' => $user->daily_salary,
                            'is_credit' => 1,
                            'entry_date' => $entry_date,
                            'purpose' => 'salary',
                            'purpose_description' => "Staff Daily Salary"
                        ]);
                    }           
                }
                echo "Salary created for ".count($staff)." staffs for ".$entry_date." ";
            } else {
                echo "No staff found";
            }
        } else {
            echo "Please add query param <strong>entry_date</strong> ";
        }
        

    }

    public function invoicePayments(Request $request)
    {
        # code...

        $voucher_no = !empty($request->voucher_no)?$request->voucher_no:'';
        $payment_amount = !empty($request->payment_amount)?$request->payment_amount:'';
        $user_id = !empty($request->user_id)?$request->store_id:'';

        // echo $voucher_no; die;

        if((!empty($voucher_no)) || (!empty($paid_amount)) || (!empty($store_id))){
            // echo $voucher_no; die;
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
        }else{
            echo 'Please add voucher_no , payment_amount and store_id as query parameter';
        }
    }

    public function staffCommission(Request $request)
    {
        # save unpaid invoice's payments
        die('Hello');

        # Get dynamic percentage value from app settings
        $app_settings = DB::table('app_settings')->find(1);
        $staff_payment_incentive = $app_settings->staff_payment_incentive;        
        $order_collector_commission = $app_settings->order_collector_commission;
        $payment_collector_commission = $app_settings->payment_collector_commission;

        /* +++++++++++++++++++++++++++++++++++++++++++++++++++++++ */

        $voucher_no = !empty($request->voucher_no)?$request->voucher_no:'';
        if(!empty($voucher_no)){
            $payment = DB::table('payment')->where('voucher_no',$voucher_no)->first();
            $payment_collector_id = $payment->staff_id;
            $payment_date = $payment->payment_date;
            // echo "payment_collector_id : ".$payment_collector_id."<br/>";
            // die;
            $paid_invoices = DB::table('invoice_payments AS ip')->select('ip.*','invoice.order_id','orders.user_id')->leftJoin('invoice', 'invoice.id','ip.invoice_id')->leftJoin('orders', 'orders.id','invoice.order_id')->where('ip.rest_amount', 0)->where('ip.voucher_no',$voucher_no)->where('ip.is_commisionable', 0)->get()->toarray();

            dd($paid_invoices);

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


                // echo "order_collector_commission_amount : ".$order_collector_commission_amount."<br/>";
                // echo "payment_collector_commission_amount : ".$payment_collector_commission_amount."<br/>";

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
                /* Getting last closing amount for order creator staff */
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
            // dd($paid_invoices);
        }else{
            echo 'Please add voucher_no in query param';
        }
        
    }

    public function saveStoreVisitLedger(Request $request)
    {
        $cost_price = "150";
        $gst_val = "18";
        $getGSTAmount = getGSTAmount($cost_price,$gst_val);
        dd($getGSTAmount);


        die();
        
    }

    public function removeLedgerRecord(Request $request)
    {
        # delete record from ledger, payment & journal...

        $transaction_id = !empty($request->transaction_id) ? $request->transaction_id : '';

        if(!empty($transaction_id)){
            $ledger = DB::table('ledger')->where('transaction_id',$transaction_id)->first();
            
            if(!empty($ledger)){
                DB::table('ledger')->where('transaction_id',$transaction_id)->delete();
                DB::table('payment')->where('voucher_no',$transaction_id)->delete();
                echo "Delete records for Transaction Id:- ".$transaction_id;
            }
            $journal = DB::table('journal')->where('purpose_id',$transaction_id)->first();
            if(!empty($journal)){
                DB::table('journal')->where('purpose_id',$transaction_id)->delete();
                DB::table('payment')->where('voucher_no',$transaction_id)->delete();
                echo "Delete records for Transaction Id:- ".$transaction_id;
            }
        } else {
            die("Please add {transaction_id} as query param ");
        }
    }

    public function checkDistance(Request $request)
    {
        # code...
        $lat1 = !empty($request->lat1)?$request->lat1:'0.0';
        $long1 = !empty($request->long1)?$request->long1:'0.0';
        $lat2 = !empty($request->lat2)?$request->lat2:'22.5761045';
        $long2 = !empty($request->long2)?$request->long2:'88.4338093';

        
        $GetDrivingDistanceTest = GetDrivingDistanceTest($lat1,$long1,$lat2,$long2);

        dd($GetDrivingDistanceTest);
    }
}
