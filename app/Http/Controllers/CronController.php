<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseOrder;

class CronController extends Controller
{
    //

    public function test()
    {
        echo 'Hello';
        

    }

    public function generateTask()
    {
        // echo "Hello! It's cron job";

        DB::table('test_cron')->insert(['unique_id'=>uniqid().' created at '.date('Y-m-d') , 'description' => 'generateTask'  ]);
        
        $start_date = date("Y-m-d", strtotime("last sunday"));
        $end_date = date("Y-m-d", strtotime("next saturday"));

        $staff = DB::table('users')->select('id','name','monthly_salary','daily_salary')->where('type', 2)->where('status', 1)->get();
        if(!empty($staff)){
            foreach($staff as $user){
                /* Salary Generation */
                
                $checkExistSalaryDayLedger = DB::table('ledger')->where('staff_id',$user->id)->where('purpose','salary')->where('entry_date', date('Y-m-d'))->first();
                if(empty($checkExistSalaryDayLedger)){
                    $transaction_id = "SAL".$user->id."".date('Ymd').time();
                    $user->salary_id = $transaction_id;
                    DB::table('ledger')->insert([
                        'user_type' => 'staff',
                        'staff_id' => $user->id,
                        'transaction_id' => $transaction_id,
                        'transaction_amount' => $user->daily_salary,
                        'is_credit' => 1,
                        'entry_date' => date('Y-m-d'),
                        'purpose' => 'salary',
                        'purpose_description' => "Staff Daily Salary"
                    ]);
                }              


                /* Task Generation */
                $checkTask = DB::table('tasks')->where('user_id',$user->id)->orderBy('id','desc')->first();
                
                if(!empty($checkTask)){
                    $user->existTask = 1;
                    $user->checkTask = $checkTask;

                    if($checkTask->start_date != $start_date && $checkTask->end_date != $end_date){
                        $id = DB::table('tasks')->insertGetId([
                            'user_id' => $user->id,
                            'start_date' => $start_date,
                            'end_date' => $end_date,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                        $taskDetails = DB::table('task_details')->where('task_id',$checkTask->id)->get();
                        if(!empty($taskDetails)){
                            foreach($taskDetails as $td){
                                DB::table('task_details')->insert([
                                    'task_id'=>$id,
                                    'store_id'=>$td->store_id,
                                    'no_of_visit'=>$td->no_of_visit,
                                    'created_at' => date('Y-m-d H:i:s'),
                                    'updated_at' => date('Y-m-d H:i:s')
                                ]);
                            }
                        }
                    }

                }else{
                    $user->existTask = 0;
                    $user->checkTask = (object) [];
                }
            }
        }
        
    }

}
