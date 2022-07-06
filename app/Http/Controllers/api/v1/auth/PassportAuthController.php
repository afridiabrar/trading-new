<?php

namespace App\Http\Controllers\api\v1\auth;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Rules\MatchOldPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use App\Mail\MyDemoMail;
use Illuminate\Support\Facades\Mail;

class PassportAuthController extends Controller
{
    public function register(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'f_name' => 'required',
                'l_name' => 'required',
                'email' => 'required|unique:users',
                'phone' => 'required|unique:users',
                'password' => 'required|min:6',
            ], [
                'f_name.required' => 'The first name field is required.',
                'l_name.required' => 'The last name field is required.',
            ]);

            if ($validator->fails()) {
                return $this->respond([], Helpers::error_processor($validator), 403);
                //                return response()->json(['errors' => Helpers::error_processor($validator)], 403);
            }

            $user = User::create([
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'account_type' => ($request->is_trader == "yes") ? 1 : 0,
            ]);
            $p = $request->all();
            $p += ['mail_title' => 'New User Singup in Trading.com'];
            $this->sendEmail($p);

            $token = $user->createToken('LaravelAuthApp')->accessToken;

            return $this->respond(['token' => $token, 'user' => $user], [], 200);




            //  return response()->json(['token' => $token,'user'=>$user], 200);

        } catch (\Exception $e) {
            return $this->respond([], [], 500, $e->getMessage());
            //            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function sendEmail($p)
    {


        $user = auth()->user();
        $user = 'developer197855@gmail.com';
        try {
            Mail::to($user)->send(new MyDemoMail($p));
        } catch (Exception $ex) {
            dd($ex);
            return $this->markdown('emails.contact.contact-form')->from('example@test.in', 'Example');
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required|min:6'
            ]);

            if ($validator->fails()) {

                return $this->respond([], Helpers::error_processor($validator), 403);
                //                return response()->json(['errors' => Helpers::error_processor($validator)], 403);
            }

            $data = [
                'email' => $request->email,
                'password' => $request->password
            ];

            $user = User::where(['email' => $request['email']])->first();

            if (isset($user) && $user->is_active && auth()->attempt($data)) {

                $token = auth()->user()->createToken('LaravelAuthApp')->accessToken;

                return $this->respond(['token' => $token, 'user' => $user], [], 200);

                //                return response()->json(['token' => $token , 'user'=>$user ], 200);

            } else {
                $errors = [];
                array_push($errors, ['code' => 'auth-001', 'message' => 'Customer not found or Account has been suspended.']);
                return $this->respond([], [], 401, 'Customer not found or Account has been suspended.');

                //                return response()->json([
                //                    'errors' => $errors,
                //                    'message' => 'Customer not found or Account has been suspended.',
                //                    'status'=> 401
                //                ], 401);
            }
        } catch (\Exception $e) {
            return $this->respond([], [], 500, $e->getMessage());
            //            return response()->json(['message' => $e->getMessage(),'status'=>500], 500);
        }
    }

    function change_password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
        try {
            User::find(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
            return $this->respond([], [], 200, "Password changed successfully.");
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->respond([], [], 500, $e->getMessage());
        }
    }
}
