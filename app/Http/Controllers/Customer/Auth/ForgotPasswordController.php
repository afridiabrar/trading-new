<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
    public function __construct()
    {
        $this->middleware('guest:customer', ['except' => ['logout']]);
    }

    public function reset_password()
    {
        return view('customer-view.auth.recover-password');
    }

    public function reset_password_request(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $customer = User::Where(['email' => $request['email']])->first();

        if (isset($customer)) {
            $token = Str::random(120);
            $customer->token = $token;
            DB::table('password_resets')->insert([
                'email' => $customer['email'],
                'token' => $token,
                'created_at' => now(),
            ]);

//            $reset_url = url('/') . '/customer/auth/reset-password?token=' . $token;
            Mail::to($customer['email'])->send(new \App\Mail\CustomerResetPasswordMail($customer->toArray()));

            Toastr::success('Check your email. Password reset url sent.');
            return back();
        }

        Toastr::error('No such email found!');
        return back();
    }

    public function reset_password_index($token)
    {
        $data = DB::table('password_resets')->where(['token' => $token])->first();
        if (isset($data)) {
            $token = $token;
            return view('customer-view.auth.reset-password', compact('token'));
        }
        Toastr::error('Invalid URL.');
        return redirect('/');
    }

    public function reset_password_submit(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|same:confirm_password',
            'confirm_password' => 'required_with:password|min:6'
        ]);

        $data = DB::table('password_resets')->where(['token' => $request['token']])->first();

        if (isset($data)) {
                DB::table('users')->where(['email' => $data->email])->update([
                    'password' => bcrypt($request['password'])
                ]);
                Toastr::success('Password reset successfully.');
                DB::table('password_resets')->where(['token' => $request['token']])->delete();
                return redirect('/');
        }
        Toastr::error('Invalid URL.');
        return redirect('/');
    }
}
