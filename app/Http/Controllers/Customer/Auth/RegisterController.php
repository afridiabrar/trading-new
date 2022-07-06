<?php

namespace App\Http\Controllers\Customer\Auth;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customer', ['except' => ['logout']]);
    }

    public function register()
    {
        session()->put('keep_return_url', url()->previous());
//        return view('customer-view.auth.register');
        return view('front.signup');
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:80|regex:/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/',
            'phone' => 'required|max:25',
            'password' => 'required|min:6|same:confirm_password',
            'confirm_password' => 'required_with:password|min:6'
        ],[
            'email.regex' => 'Please provide a valid email'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

//        if ($request['password'] != $request['con_password']) {
//            return response()->json(['errors' => ['code' => '', 'message' => 'password does not match.']],403);
//        }

        if (session()->has('keep_return_url')==false){
            session()->put('keep_return_url', url()->previous());
        }

        DB::table('users')->insert([
            'f_name' => $request['first_name'],
            'l_name' => $request['last_name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'password' => bcrypt($request['password'])
        ]);

        if (auth('customer')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->route('customer.auth.login')->with('success','Sign up process done successfully!');
//            return response()->json(['message' => 'Sign up process done successfully!', 'url' => session('keep_return_url')]);
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['Something went wrong.']);
    }
}
