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

class PartnerController extends Controller
{
    /* Login */

    public function login(Request $request)
    {
        # partner login...

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'exists:admins,email'],
            'password' => ['required'],                       
        ]);

        if (!$validator->fails()) {
            $params = $request->except('_token');
            $email = $params['email'];
            $password = $params['password'];
            $user = DB::table('admins')->where('email',$email)->where('type',1)->where('status',1)->first();
            if(!empty($user)){
                if(Hash::check($password, $user->password)){
                    $id = $user->id;
                    // $token = Crypt::encrypt($id);
                    return response()->json(['error' => false, 'message' => 'Logged in sucessfully', 'data' => array('user'=>$user) ], 200);
                } else {
                    return response()->json(['error' => true, 'message' => 'Password mismatch', 'data' => array() ]);
                }
            } else {
                return response()->json(['error' => true, 'message' => 'No partner found', 'data' => array() ]);
            }
            
        } else {
            return response()->json(['status' => 400, 'message' => $validator->errors()->first()],400);
        }

    }


}
