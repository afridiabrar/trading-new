<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\CustomerManager;
use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\ShippingAddress;
use App\Model\SupportTicket;
use App\Model\SupportTicketConv;
use App\Model\Wishlist;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
    public function info(Request $request)
    {
        try {

            $user = User::where('id',$request->user()->id)->first();

            return $this->respond(['user'=>$user],[],200);

        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function create_support_ticket(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'type' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $request['customer_id'] = $request->user()->id;
        $request['priority'] = 'low';
        $request['status'] = 'pending';

        try {
            CustomerManager::create_support_ticket($request);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => [
                    'code' => 'failed',
                    'message' => 'Something went wrong',
                ],
            ], 422);
        }
        return response()->json(['message' => 'Support ticket created successfully.'], 200);
    }

    public function reply_support_ticket(Request $request, $ticket_id)
    {
        $support = new SupportTicketConv();
        $support->support_ticket_id = $ticket_id;
        $support->admin_id = 1;
        $support->customer_message = $request['message'];
        $support->save();
        return response()->json(['message' => 'Support ticket reply sent.'], 200);
    }

    public function get_support_tickets(Request $request)
    {
        return response()->json(SupportTicket::where('customer_id', $request->user()->id)->get(), 200);
    }

    public function get_support_ticket_conv($ticket_id)
    {
        return response()->json(SupportTicketConv::where('support_ticket_id', $ticket_id)->get(), 200);
    }

    public function add_to_wishlist(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->respond([],Helpers::error_processor($validator),403,'Request Bad Validation');
            }

            $wishlist = Wishlist::where('customer_id', $request->user()->id)->where('product_id', $request->product_id)->first();

            if (empty($wishlist)) {
                $wishlist = new Wishlist;
                $wishlist->customer_id = $request->user()->id;
                $wishlist->product_id = $request->product_id;
                $wishlist->save();

                $newWishlist = Wishlist::with(['product'])->where('id', $wishlist->id)->first();

                return $this->respond(['wishlist'=> $newWishlist ],[],200,'successfully added!');
            }

            return $this->respond([],[],409,'Already in your wishlist');

        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function remove_from_wishlist(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->respond([],Helpers::error_processor($validator),403);
            }

            $wishlist = Wishlist::where('customer_id', $request->user()->id)
                ->where('product_id', $request->product_id)->first();

            if (!empty($wishlist)) {
                Wishlist::where(['customer_id' => $request->user()->id, 'product_id' => $request->product_id])
                    ->delete();
                return $this->respond([],[],200,'successfully removed!');
            }

            return $this->respond([],[],404,'No such data found!');


        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }

    }

    public function remove_all_wishlist(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'customer_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->respond([],Helpers::error_processor($validator),403);
            }

            $wishlist = Wishlist::where('customer_id', $request->user()->id)
                ->get();

            if (!empty($wishlist)) {
                Wishlist::where(['customer_id' => $request->user()->id])
                    ->delete();
                return $this->respond([],[],200,'successfully removed!');
            }

            return $this->respond([],[],404,'No such data found!');


        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }

    }

    public function wish_list(Request $request)
    {
        try {

            $wishList = Wishlist::with(['product'])->where('customer_id', $request->user()->id)
                ->paginate(12, ['*'], 'page', 1);
            return $this->respond(['wishlist' => $wishList],[],200,'');

        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function address_list(Request $request)
    {
        return response()->json(ShippingAddress::where('customer_id', $request->user()->id)->get(), 200);
    }

    public function add_new_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'contact_person_name' => 'required',
            'address_type' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $address = [
            'customer_id' => $request->user()->id,
            'contact_person_name' => $request->name,
            'address_type' => $request->address_type,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'phone' => $request->phone,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shipping_addresses')->insert($address);
        return response()->json(['message' => 'successfully added!'], 200);
    }

    public function delete_address(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        if (DB::table('shipping_addresses')->where(['id' => $request['address_id'], 'customer_id' => $request->user()->id])->first()) {
            DB::table('shipping_addresses')->where(['id' => $request['address_id'], 'customer_id' => $request->user()->id])->delete();
            return response()->json(['message' => 'successfully removed!'], 200);
        }
        return response()->json(['message' => 'No such data found!'], 404);
    }

    public function get_order_list(Request $request)
    {
        try {
            $orders = Order::with(['details'])->where(['customer_id' => $request->user()->id])->
            paginate(12, ['*'], 'page', 1);
//            return response()->json($orders, 200);
            return $this->respond($orders,[],200);
        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function get_order_details(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'order_id' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->respond([],Helpers::error_processor($validator),403);
            }

            $details = OrderDetail::where(['order_id' => $request['order_id']])->get();
            $details->map(function ($query){
                $query['variation'] = json_decode($query['variation'], true);
                $query['product_details'] = Helpers::product_data_formatting(json_decode($query['product_details'], true));
                return $query;
            });
//            return response()->json($details, 200);
            return $this->respond($details,[],200);

        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function update_profile(Request $request)
    {
//        return $request->all();
        try {
            $validator = Validator::make($request->all(), [
                'f_name' => 'required',
                'l_name' => 'required',
//                'email' => 'email|required',
                'phone' => 'required',
                'street_address' => 'string|required',
                'city' => 'string|required',
                'zip' => 'string|required',
                'gender' => 'string|required',
//                'dob' => 'string|required',
            ],[
                'f_name.required' => 'First name is required!',
                'l_name.required' => 'Last name is required!',
                'email' => 'Email is required!',
                'phone' => 'Phone is required!',
                'street_address' => 'Address is required!',
            ]);

            if ($validator->fails()) {
                return $this->respond([],Helpers::error_processor($validator),403,'');
            }

            if ($request->has('image')) {
                $imageName = ImageManager::update('profile/', $request->user()->image, 'png', $request->file('image'));
            } else {
                $imageName = $request->user()->image;
            }

//            if ($request['password'] != null && strlen($request['password']) > 5) {
//                $pass = bcrypt($request['password']);
//            } else {
//                $pass = $request->user()->password;
//            }

            $userDetails = [
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'phone' => $request->phone,
                'image' => $imageName,
                'street_address' => $request->input('street_address'),
//                'country' => $request->input('country'),
                'city' => $request->input('city'),
                'zip' => $request->input('zip'),
//                'dob' => $request->input('dob'),
                'gender' => $request->input('gender'),
//                'password' => $pass,
                'updated_at' => now(),
            ];

            User::where(['id' => $request->user()->id])->update($userDetails);

            $user = User::where(['id' => $request->user()->id])->first();

            return $this->respond(['user'=>$user],[],200,'Successfully Updated!');

        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function update_cm_firebase_token(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cm_firebase_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        DB::table('users')->where('id', $request->user()->id)->update([
            'cm_firebase_token' => $request['cm_firebase_token'],
        ]);

        return response()->json(['message' => 'successfully updated!'], 200);
    }
}
