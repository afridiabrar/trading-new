<?php

namespace App\Http\Controllers\api\v1\auth;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPassword extends Controller
{
    public function reset_password_request(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => Helpers::error_processor($validator)], 403);
            }

            $customer = User::Where(['email' => $request['email']])->first();

            if (isset($customer)) {
                $token = Str::random(20);
                DB::table('password_resets')->insert([
                    'email' => $customer['email'],
                    'token' => $token,
                    'created_at' => now(),
                ]);
                $reset_url = url('/') . '/customer/auth/reset-password?token=' . $token;
                $reset_url = 'http://192.168.3.114:3000/newpassword?token='.$token;
                Mail::to($customer['email'])->send(new \App\Mail\PasswordResetMail($reset_url));
                return $this->respond([],[],200,"Email sent successfully.");
//                return response()->json(['message' => 'Email sent successfully.'], 200);
            }
//            return response()->json(['errors' => [
//                ['code' => 'not-found', 'message' => 'Email not found!']
//            ]], 404);
            return $this->respond([],[],404,"Email not found!");

        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function reset_password_submit(Request $request)
    {
        try {
            $data = DB::table('password_resets')->where(['token' => $request['reset_token']])->first();
            if (isset($data)) {
                if ($request['password'] == $request['confirm_password']) {
                    DB::table('users')->where(['email' => $data->email])->update([
                        'password' => bcrypt($request['confirm_password'])
                    ]);
                    Toastr::success('Password reset successfully.');
                    DB::table('password_resets')->where(['token' => $request['reset_token']])->delete();
                    return $this->respond([],[],200,"Password changed successfully.");
//                    return response()->json(['message' => 'Password changed successfully.'], 200);
                }
//                return response()->json(['errors' => [
//                    ['code' => 'mismatch', 'message' => 'Password did,t match!']
//                ]], 401);
                return $this->respond([],[['code' => 'mismatch', 'message' => 'Password did,t match!']],401,"Password did,t match!");
            }
//            return response()->json(['errors' => [
//                ['code' => 'invalid', 'message' => 'Invalid token.']
//            ]], 400);
            return $this->respond([],[['code' => 'invalid', 'message' => 'Invalid token.']],400,"Invalid token.");

        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }

    }
}
