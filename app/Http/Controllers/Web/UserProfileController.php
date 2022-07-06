<?php

namespace App\Http\Controllers\Web;

use App\CPU\CustomerManager;
use App\CPU\Helpers;
use App\CPU\OrderManager;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\ShippingAddress;
use App\Model\SupportTicket;
use App\Model\Wishlist;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserProfileController extends Controller
{
    public function user_account(Request $request)
    {
        if (auth('customer')->check()) {
            $customerDetail = User::where('id', auth('customer')->id())->first();
            return view('front.profile', compact('customerDetail'));
        } else {
            return redirect()->route('home');
        }
    }

    public function user_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'phone' => 'required|max:25',
            'street_address' => 'max:250',
            'country' => 'max:50',
            'city' => 'max:50',
            'zip' => 'max:20',
            'dob' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

//        return $request->all();

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $data = getimagesize($image);
            $imageName = time() . "-" . uniqid() . "." . 'png';
            if (!Storage::disk('public')->exists('profile')) {
                Storage::disk('public')->makeDirectory('profile');
            }
            $note_img = Image::make($image)->fit($data[0], $data[1])->stream();
            Storage::disk('public')->put('profile/' . $imageName, $note_img);
        } else {
            $imageName = auth('customer')->user()->image;
        }

        User::where('id', auth('customer')->id())->update([
            'image' => $imageName,
        ]);

//        if ($request['password'] != $request['con_password']) {
//            Toastr::error('Password did not match.');
//            return back();
//        }

        $userDetails = [
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'phone' => $request->phone,
            'street_address' => $request->street_address,
            'country' => $request->country,
            'city' => $request->city,
            'zip' => $request->zip,
            'dob' => $request->dob,
            'gender' => $request->gender,
//            'password' => strlen($request->password) > 5 ? bcrypt($request->password) : auth('customer')->user()->password,
        ];
        if (auth('customer')->check()) {
            User::where(['id' => auth('customer')->id()])->update($userDetails);
            Toastr::success('Profile has been updated!');
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function account_address()
    {
        if (auth('customer')->check()) {
            $shippingAddresses = \App\Model\ShippingAddress::where('customer_id', auth('customer')->id())->get();
            return view('web-views.users-profile.account-address', compact('shippingAddresses'));
        } else {
            return redirect()->route('home');
        }
    }

    public function address_store(Request $request)
    {
        $address = [
            'customer_id' => auth('customer')->check() ? auth('customer')->id() : null,
            'contact_person_name' => $request->name,
            'address_type' => $request->addressAs,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'phone' => $request->phone,
            'state' => $request->state,
            'country' => $request->country,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('shipping_addresses')->insert($address);
        return back();
    }

    public function address_update(Request $request)
    {
        $updateAddress = [
            'contact_person_name' => $request->name,
            'address_type' => $request->addressAs,
            'address' => $request->address,
            'city' => $request->city,
            'zip' => $request->zip,
            'phone' => $request->phone,
            'state' => $request->state,
            'country' => $request->country,
            'created_at' => now(),
            'updated_at' => now(),
        ];
        if (auth('customer')->check()) {
            ShippingAddress::where('id', $request->id)->update($updateAddress);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function address_delete(Request $request)
    {
        if (auth('customer')->check()) {
            ShippingAddress::destroy($request->id);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function account_payment()
    {
        if (auth('customer')->check()) {
            return view('web-views.users-profile.account-payment');

        } else {
            return redirect()->route('home');
        }

    }

    public function account_order()
    {
        $orders = Order::where('customer_id', auth('customer')->id())->latest()->paginate(5);
        return view('web-views.users-profile.account-orders', compact('orders'));
    }

//    public function account_order()
//    {
//        $orders = Order::where('customer_id', auth('customer')->id())->latest()->get();
//        return view('web-views.users-profile.account-orders', compact('orders'));
//    }

    public function account_order_details($order_id)
    {
        $order = Order::join('shipping_addresses', 'orders.shipping_address', '=', 'shipping_addresses.id')
            ->join('users', 'orders.customer_id', '=', 'users.id')
            ->select('orders.*', 'shipping_addresses.address', 'users.phone as customer_phone')
            ->where('orders.id', $order_id)
            ->first();
        $order_details = DB::table('order_details')->join('shipping_methods', 'order_details.shipping_method_id', '=', 'shipping_methods.id')->select('order_details.*', 'shipping_methods.cost')->where('order_id', $order->id)->get();

        $track_order = OrderManager::track_order($order->id);
        $returnHTML = view('web-views.users-profile.account-order-details',
            ['order'=> $order, 'order_details' => $order_details, 'track_order' => $track_order])
            ->render();
        return response()->json( ['html' => $returnHTML]);
//        return view('web-views.users-profile.account-order-details', compact('order', 'order_details'));
    }

    public function account_wishlist()
    {
        if (auth('customer')->check()) {
            $wishlists = Wishlist::where('customer_id', auth('customer')->id())->get();
            return view('web-views.products.wishlist', compact('wishlists'));
        } else {
            return redirect()->route('home');
        }
    }

    public function account_tickets()
    {
        if (auth('customer')->check()) {
            $supportTickets = SupportTicket::where('customer_id', auth('customer')->id())->get();
            return view('web-views.users-profile.account-tickets', compact('supportTickets'));
        } else {
            return redirect()->route('home');
        }
    }

    public function ticket_submit(Request $request)
    {
        $ticket = [
            'subject' => $request['ticket_subject'],
            'type' => $request['ticket_type'],
            'customer_id' => auth('customer')->check() ? auth('customer')->id() : null,
            'priority' => $request['ticket_priority'],
            'description' => $request['ticket_description'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
        DB::table('support_tickets')->insert($ticket);
        return back();
    }

    public function single_ticket(Request $request)
    {
        $ticket = SupportTicket::where('id', $request->id)->first();
        return view('web-views.users-profile.ticket-view', compact('ticket'));
    }

    public function comment_submit(Request $request, $id)
    {
        DB::table('support_tickets')->where(['id' => $id])->update([
            'status' => 'open',
            'updated_at' => now(),
        ]);

        DB::table('support_ticket_convs')->insert([
            'customer_message' => $request->comment,
            'support_ticket_id' => $id,
            'position' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return back();
    }

    public function support_ticket_close($id)
    {
        DB::table('support_tickets')->where(['id' => $id])->update([
            'status' => 'close',
            'updated_at' => now(),
        ]);
        Toastr::success('Ticket closed!');
        return redirect('/account-tickets');
    }

    public function account_transaction()
    {
        $customer_id = auth('customer')->id();
        $customer_type = 'customer';
        if (auth('customer')->check()) {
            $transactionHistory = CustomerManager::user_transactions($customer_id, $customer_type);
            return view('web-views.users-profile.account-transaction', compact('transactionHistory'));
        } else {
            return redirect()->route('home');
        }
    }

    public function support_ticket_delete(Request $request)
    {

        if (auth('customer')->check()) {
            $support = SupportTicket::find($request->id);
            $support->delete();
            return redirect()->back();
        } else {
            return redirect()->back();
        }

    }

    public function account_wallet_history($user_id, $user_type = 'customer')
    {
        $customer_id = auth('customer')->id();
        $customer_type = 'customer';
        if (auth('customer')->check()) {
            $wallerHistory = CustomerManager::user_wallet_histories($customer_id);
            return view('web-views.users-profile.account-wallet', compact('wallerHistory'));
        } else {
            return redirect()->route('home');
        }

    }

    public function track_order()
    {
        return view('web-views.order-tracking-page');
    }

    public function track_order_result(Request $request)
    {
        $orderDetails = OrderManager::track_order($request['order_id']);

        if (isset($orderDetails)) {
            $customer = User::find($orderDetails->customer_id);

            if ($orderDetails != null && $customer->phone == $request->phone_number) {
                return view('web-views.order-tracking', compact('orderDetails'));
            } else {
                return redirect()->route('track-order.index')->with('Error', 'Invalid Order Id or Phone Number');
            }
        } else {
            return redirect()->route('track-order.index')->with('Error', 'Invalid Order Id or Phone Number');
        }

    }

    public function track_last_order()
    {
        $orderDetails = OrderManager::track_order(Order::where('customer_id', auth('customer')->id())->latest()->first()->id);

        if ($orderDetails != null) {
            return view('web-views.order-tracking', compact('orderDetails'));
        } else {
            return redirect()->route('track-order.index')->with('Error', 'Invalid Order Id or Phone Number');
        }

    }

    public function order_cancel($id)
    {
        $order = Order::where(['id' => $id])->first();
        if ($order['payment_method'] == 'cash_on_delivery' && $order['order_status'] == 'pending') {
            OrderManager::stock_update_on_order_status_change($order, 'canceled');
            Order::where(['id' => $id])->update([
                'order_status' => 'canceled'
            ]);
            Toastr::success('Order canceled successfully!');
            return back();
        }
        Toastr::error('Order status is not changeable now');
        return back();
    }

    public function generate_invoice($id)
    {
        $order = Order::with('shipping')->where('id', $id)->first();
//        dd($order)->toArray();

        $data["email"] = $order->customer["email"];
        $data["client_name"] = $order->customer["f_name"] . ' ' . $order->customer["l_name"];
        $data["order"] = $order;

//        return view('web-views.invoice', compact('order'));

        $pdf = PDF::loadView('web-views.invoice', $data);
        return $pdf->download('00' . $order->id . '.pdf');
    }

    public function account_security()
    {
        return view('web-views.users-profile.account-security');
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|same:confirm_password',
            'confirm_password' => 'required'
        ]);

        if (Hash::check($request->input('password'), auth('customer')->user()->password)) {
            Toastr::error('Please choose a new password!');
            return back();
        }

        $user = User::find(auth('customer')->user()->id);
        $user->password = bcrypt($request->input('password'));
        $user->save();

        Toastr::success('Password has been updated!');
        return back();
    }
}
