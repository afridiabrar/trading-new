<?php

namespace App\CPU;

use App\Model\Admin;
use App\Model\AdminWallet;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Product;
use App\Model\SellerWallet;
use App\Model\ShippingAddress;
use App\Model\ShippingMethod;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderManager
{
    public static function track_order($order_id)
    {
        return Order::with(['details'])->where(['id' => $order_id])->first();
    }

    public static function place_order(
        $customer_id,
        $email,
        $customer_info,
        $cart,
        $payment_method,
        $discount,
        $ref_id
    )
    {
        $shippingAddressData = [
            'customer_id' => $customer_id,
            'email' => $customer_info['email'],
            'contact_person_name' => $customer_info['firstName'].' '.$customer_info['lastName'],
            'address_type' => 'home',
            'phone' => $customer_info['phone'],
            'address' => $customer_info['address'],
            'city' => $customer_info['townCity'],
            'country' => $customer_info['region']
        ];

        $shippingAddress = ShippingAddress::create($shippingAddressData);

        $or = [
                'id' => 100000 + Order::all()->count() + 1,
                'customer_id' => $customer_id,
                'customer_type' => 'customer',
                'payment_status' => 'paid',
                'order_status' => 'processing',
                'payment_method' => $payment_method,
                'transaction_ref' => $ref_id,
                'discount_amount' => $discount,
                'discount_type' => $discount == 0 ? null : 'coupon_discount',
                'order_amount' => CartManager::cart_grand_total($cart) - $discount,
//                'order_amount' => floatval($totalAmount) - $discount,
                'shipping_address' => $shippingAddress->id,
                'tracking_status' => 'waiting_for_driver_assignment',
                'created_at' => now(),
                'updated_at' => now()
            ];

//        return ['$customer_info'=>$customer_info , 'cart'=>$cart ];



//            $o_id = DB::table('orders')->insertGetId($or);
            $o_id = Order::create($or);
            $o_id = $o_id->id ;


        foreach ($cart as $c) {
                $product = Product::where('id', $c['id'])->first();

                $or_d = [
                    'order_id' => $o_id,
                    'product_id' => $c['id'],
                    'seller_id' => (!empty($product->added_by) && $product->added_by == 'seller') ? $product->user_id : '0',
                    'product_details' => $product,
                    'qty' => $c['quantity'],
                    'price' => $c['price'],
                    'tax' => (!empty($c['tax']))? $c['tax'] * $c['quantity'] : 0,
                    'discount' => (!empty($c['discount']))? $c['discount'] * $c['quantity'] : 0,
                    'discount_type' => 'discount_on_product',
                    'variant' => (!empty($c['variant']))? $c['variant'] : '',
                    'variation' => (!empty($c['variations']))? json_encode($c['variations']) : null,
                    'delivery_status' => 'pending',
                    'shipping_method_id' => (!empty($c['shipping_method_id']))? $c['shipping_method_id'] : 0,
                    'payment_status' => 'unpaid',
                    'created_at' => now(),
                    'updated_at' => now()
                ];


//                if (!empty($c['variations']) && $c['variations'] != null) {
//                    $type = $c['variations'][0]['type'];
//                    $var_store = [];
//                    foreach (json_decode($product['variation'], true) as $var) {
//                        if ($type == $var['type']) {
//                            $var['qty'] -= $c['quantity'];
//                        }
//                        array_push($var_store, $var);
//                    }
//                    Product::where(['id' => $product['id']])->update([
//                        'variation' => json_encode($var_store),
//                    ]);
//                }
                if(!empty($product)){
                    Product::where(['id' => $product['id']])->update([
                        'current_stock' => $product['current_stock'] - $c['quantity']
                    ]);
                }

            DB::table('order_details')->insert($or_d);
            }

            if($customer_id !== 0){
                $fcm_token = User::where(['id' => $customer_id])->first()->cm_firebase_token;
                $value = \App\CPU\Helpers::order_status_update_message('pending');
//            try {
                if ($value) {
                    $data = [
                        'title' => 'Order',
                        'description' => $value,
                        'order_id' => $o_id,
                        'image' => '',
                    ];
                    Helpers::send_push_notif_to_device($fcm_token, $data);
                }
            }
//            } catch (\Exception $e){
//            }

            Mail::to($email)->send(new \App\Mail\OrderPlaced($o_id));
            return $o_id;
//        } catch (\Exception $e){
//        }

    }

    public static function stock_update_on_order_status_change($order, $status)
    {
        if ($status == 'returned' || $status == 'failed' || $status == 'canceled') {
            foreach ($order->details as $detail) {
                if ($detail['is_stock_decreased'] == 1) {
                    $product = Product::find($detail['product_id']);
                    $type = $detail['variant'];
                    $var_store = [];
                    foreach (json_decode($product['variation'], true) as $var) {
                        if ($type == $var['type']) {
                            $var['qty'] += $detail['qty'];
                        }
                        array_push($var_store, $var);
                    }
                    Product::where(['id' => $product['id']])->update([
                        'variation' => json_encode($var_store),
                        'current_stock' => $product['current_stock'] + $detail['qty'],
                    ]);
                    OrderDetail::where(['id' => $detail['id']])->update([
                        'is_stock_decreased' => 0
                    ]);
                }
            }
        } else {
            foreach ($order->details as $detail) {
                if ($detail['is_stock_decreased'] == 0) {
                    $product = Product::find($detail['product_id']);

                    //check stock
                    /*foreach ($order->details as $c) {
                        $product = Product::find($c['product_id']);
                        $type = $detail['variant'];
                        foreach (json_decode($product['variation'], true) as $var) {
                            if ($type == $var['type'] && $var['qty'] < $c['qty']) {
                                Toastr::error('Stock is insufficient!');
                                return back();
                            }
                        }
                    }*/

                    $type = $detail['variant'];
                    $var_store = [];
                    foreach (json_decode($product['variation'], true) as $var) {
                        if ($type == $var['type']) {
                            $var['qty'] -= $detail['qty'];
                        }
                        array_push($var_store, $var);
                    }
                    Product::where(['id' => $product['id']])->update([
                        'variation' => json_encode($var_store),
                        'current_stock' => $product['current_stock'] - $detail['qty'],
                    ]);
                    OrderDetail::where(['id' => $detail['id']])->update([
                        'is_stock_decreased' => 1
                    ]);
                }
            }
        }
    }

    public static function stock_update_on_product_status_change($ordered_product, $status)
    {
        if ($status == 'returned' || $status == 'failed' || $status == 'canceled') {
            if ($ordered_product['is_stock_decreased'] == 1) {
                $product = Product::find($ordered_product['product_id']);
                $type = $ordered_product['variant'];
                $var_store = [];
                foreach (json_decode($product['variation'], true) as $var) {
                    if ($type == $var['type']) {
                        $var['qty'] += $ordered_product['qty'];
                    }
                    array_push($var_store, $var);
                }
                Product::where(['id' => $product['id']])->update([
                    'variation' => json_encode($var_store),
                    'current_stock' => $product['current_stock'] + $ordered_product['qty'],
                ]);
                OrderDetail::where(['id' => $ordered_product['id']])->update([
                    'is_stock_decreased' => 0
                ]);
            }
        } else {
            if ($ordered_product['is_stock_decreased'] == 0) {
                $product = Product::find($ordered_product['product_id']);

                //check stock
                /*foreach ($order->details as $c) {
                    $product = Product::find($c['product_id']);
                    $type = $detail['variant'];
                    foreach (json_decode($product['variation'], true) as $var) {
                        if ($type == $var['type'] && $var['qty'] < $c['qty']) {
                            Toastr::error('Stock is insufficient!');
                            return back();
                        }
                    }
                }*/

                $type = $ordered_product['variant'];
                $var_store = [];
                foreach (json_decode($product['variation'], true) as $var) {
                    if ($type == $var['type']) {
                        $var['qty'] -= $ordered_product['qty'];
                    }
                    array_push($var_store, $var);
                }
                Product::where(['id' => $product['id']])->update([
                    'variation' => json_encode($var_store),
                    'current_stock' => $product['current_stock'] - $ordered_product['qty'],
                ]);
                OrderDetail::where(['id' => $ordered_product['id']])->update([
                    'is_stock_decreased' => 1
                ]);
            }
        }
    }

    public static function wallet_manage_on_order_status_change($order, $request)
    {
        if ($order->seller_id != 0 && $request->delivery_status == 'delivered') {
            $commission_amount = Helpers::sales_commission($order);
            $shipping = ShippingMethod::find($order->shipping_method_id);
            $tax = $order->tax;
            $discount = $order->discount;
            $total = ($order->price * $order->qty) + $tax - $discount + ($shipping->creator_type == 'seller' ? $shipping->cost : 0);

            DB::table('seller_wallet_histories')->insert([
                'seller_id' => $order->seller_id,
                'amount' => $total - $commission_amount,
                'order_id' => $order->order_id,
                'product_id' => $order->product_id,
                'payment' => 'received',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('admin_wallet_histories')->insert([
                'admin_id' => Admin::where('admin_role_id', 1)->first()->id,
                'amount' => $commission_amount + ($shipping->creator_type == 'admin' ? $shipping->cost : 0),
                'order_id' => $order->order_id,
                'product_id' => $order->product_id,
                'payment' => 'received',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (SellerWallet::where('seller_id', $order->seller_id)->first() == false) {
                DB::table('seller_wallets')->insert([
                    'seller_id' => $order->seller_id,
                    'balance' => 0,
                    'withdrawn' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            if (AdminWallet::where('admin_id', Admin::where('admin_role_id', 1)->first()->id)->first() == false) {
                DB::table('admin_wallets')->insert([
                    'admin_id' => Admin::where('admin_role_id', 1)->first()->id,
                    'balance' => 0,
                    'withdrawn' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('seller_wallets')->where('seller_id', $order->seller_id)->increment('balance', $total - $commission_amount);
            DB::table('admin_wallets')->where('admin_id', Admin::where('admin_role_id', 1)->first()->id)->increment('balance', $commission_amount + ($shipping->creator_type == 'admin' ? $shipping->cost : 0));

        } elseif ($order->seller_id == 0 && $request->delivery_status == 'delivered') {
            $shipping = ShippingMethod::find($order->shipping_method_id);
            $tax = $order->tax;
            $discount = $order->discount;
            $total = ($order->price * $order->qty) + $tax - $discount + $shipping->cost;

            DB::table('admin_wallet_histories')->insert([
                'admin_id' => Admin::where('admin_role_id', 1)->first()->id,
                'amount' => $total,
                'order_id' => $order->order_id,
                'product_id' => $order->product_id,
                'payment' => 'received',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            if (AdminWallet::where('admin_id', Admin::where('admin_role_id', 1)->first()->id)->first() == false) {
                DB::table('admin_wallets')->insert([
                    'admin_id' => Admin::where('admin_role_id', 1)->first()->id,
                    'balance' => 0,
                    'withdrawn' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::table('admin_wallets')->where('admin_id', Admin::where('admin_role_id', 1)->first()->id)->increment('balance', $total);
        }
    }
}
