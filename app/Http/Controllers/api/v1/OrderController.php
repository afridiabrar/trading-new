<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\CartManager;
use App\CPU\Helpers;
use App\CPU\OrderManager;
use App\Exceptions\Handler;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stripe\Charge;
use Stripe\Stripe;

class OrderController extends Controller
{
    public function track_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required'
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        return response()->json(OrderManager::track_order($request['order_id']), 200);
    }

    public function place_order(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
//                'f_name' => 'string|required',
//                'l_name' => 'string|required',
//                'email' => 'email|required',
//                'address' => 'string|required',
//                'city' => 'string|required',
//                'state' => 'string|required',
//                'zip' => 'string|required',
                'role' => 'string|required|in:trader,customer',
                'customer_info' => 'required',
                'cart' => 'required', // [1 ,2 ,3]
                'stripe_token' => 'string|required', // [1 ,2 ,3]
//                'discount' => 'required',
//                'token' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->respond([],Helpers::error_processor($validator),403,'bad request');
            }



//            if ( $request->role === "trader" && !Auth::guard('api')->check())
//            {
//                return $this->unauthorized();
//            }
//            return $this->respond([],[],200,'response');



//            foreach ($request['cart'] as $k=>$c) {
//                $product = Product::find($c['id']);
//                if (!empty($product)) {
//                    $request['cart'][$k]['productitem'] = $product;
//                    $type = $c['variations'][0]['type'];
//                    foreach (json_decode($product['variation'], true) as $var) {
//                        if ($type == $var['type'] && $var['qty'] < $c['quantity']) {
//                            $validator->getMessageBag()
//                            ->add('stock', 'Stock is insufficient! available stock ' . $var['qty']);
//                        }
//                    }
//                }
//            }


//            if ($validator->getMessageBag()->count() > 0) {
//                return $this->respond([],Helpers::error_processor($validator),403);
////                return response()->json(['errors' => Helpers::error_processor($validator)], 403);
//            }

//            return response()->json(json_decode($request->input('customer_info'),true), 403);
//            die;
//            return [
//                'customer'=> json_decode($request['customer_info'],true),
//                'cart'=> json_decode($request['cart'],true),
//            ];

//            $request['customer_info'] = json_decode($request['customer_info'],true);
//            return $this->respond([],[],200,Auth::guard('api')->user());

//            $id = 0;
//            $email = (!empty($request['customer_info']) && !empty($request['customer_info']['email']))? $request['customer_info']['email'] : '';
//            if($request->role === "trader"){
                $id = $request->user('api')->id;
                $email = $request->user('api')->email;
//            }

//            return $this->respond([$email,$id],[],200,$request->user('api')->id);

            Stripe::setApiKey(config('STRIPE_KEY','sk_test_51LDNsIIXSseLhvkZx5H3UlJTjGnGEcIJD73SHtHHarwBlPER3uZAEAUdsstrUKfklI5hG7WbcKnDMuE4JcvXvjNS00wMzAEtmg'));

                       // sprintf("%.2f", $request['discount'])
                    //    floatval
                    // number_format( $request['cart'], 2, '.', '');
            $amount = CartManager::cart_grand_total( $request['cart']) - ($request['discount'] ? $request['discount'] : 0 );
//            return $amount;

            $x = Charge::create ([
                "amount" => $amount * 100,
                "currency" => "usd",
                "source" => $request->input('stripe_token'),
                "description" => "New Order"
            ]);

            if(!empty($x)){
                $data = OrderManager::place_order(
                    $id,
                    $email,
                    $request['customer_info'],
                    $request['cart'],
                    null,
                    ( $request['discount']? $request['discount'] : 0),
                    $x['id']
                );

                $order_details = Order::with(['details'])->where(['id' => $data])->first();


                return $this->respond(['order'=>$order_details],[],200,'Order placed successfully!');
            }else{
                return $this->respond($x,[],404,'stripe token error');
            }

        }catch (\Exception $e){
            return $this->respond($request->all(),[],500,$e->getMessage());
        }
    }

    public function tracking_order($tracking_id)
    {
//        return $tracking_id;die;
        try {
            $order_details = Order::where('id',$tracking_id)->first();

            if(empty($order_details)){
                return $this->respond([],[],404,'Order Not Found!');
            }

            $tracking_status = $order_details->tracking_status;

            $waiting_for_driver_assignment = $order_picked_up_from_location = $order_on_way = $delivered = false;

            if($tracking_status == "waiting_for_driver_assignment"){
                $waiting_for_driver_assignment = true;
            }
            if($tracking_status == "order_picked_up_from_location"){
                $waiting_for_driver_assignment = true;
                $order_picked_up_from_location = true;
            }
            if($tracking_status == "order_on_way"){
                $waiting_for_driver_assignment = true;
                $order_picked_up_from_location = true;
                $order_on_way = true;
            }
            if($tracking_status == "delivered"){
                $waiting_for_driver_assignment = true;
                $waiting_for_driver_assignment = true;
                $order_on_way = true;
                $delivered = true;
            }
            $status = array(
                'waiting_for_driver_assignment' => $waiting_for_driver_assignment,
                'order_picked_up_from_location' => $order_picked_up_from_location,
                'order_on_way' => $order_on_way,
                'delivered' => $delivered,
            );
            return $this->respond(['status'=>$status],[],200,'Success');
        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }
}
