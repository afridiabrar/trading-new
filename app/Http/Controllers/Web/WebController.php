<?php

namespace App\Http\Controllers\Web;

use App\CPU\CartManager;
use App\CPU\Helpers;
use App\CPU\ProductManager;
use App\Http\Controllers\Controller;
use App\Model\Admin;
use App\Model\Banner;
use App\Model\Blog;
use App\Model\Brand;
use App\Model\BusinessSetting;
use App\Model\Category;
use App\Model\Consignments;
use App\Model\Contact;
use App\Model\DealOfTheDay;
use App\Model\FlashDeal;
use App\Model\FlashDealProduct;
use App\Model\HelpTopic;
use App\Model\LookBook;
use App\Model\Order;
use App\Model\OrderDetail;
use App\Model\Product;
use App\Model\RequestItem;
use App\Model\Review;
use App\Model\Seller;
use App\Model\ShippingAddress;
use App\Model\ShippingMethod;
use App\Model\Shop;
use App\Model\Wishlist;
use App\Newsletter;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class WebController extends Controller
{

    public function maintenance_mode()
    {
        $maintenance_mode = Helpers::get_business_settings('maintenance_mode') ?? 0;
        if ($maintenance_mode) {
            return view('web-views.maintenance-mode');
        }
        return redirect()->route('home');
    }

    public function home()
    {
        return redirect()->route('admin.auth.login');
        $banners = Banner::where('banner_type', 'Main Banner')
            ->where('published', 1)
            ->orderBy('id', 'desc')
            ->get();

        $latest_blogs = Blog::where(
            [
                'published' => 1,
                'deleted_at' => null
            ]
        )
            ->latest()
            ->limit(2)
            ->get();

        $home_categories = Category::with(['childes'])
            ->where('home_status', true)
            ->first();

        $shop_by_style = Category::with('childes')
            ->where('slug', 'style')
            ->first();

        //products based on top seller
        $top_sellers = Seller::where(['status' => 'approved'])->with('shop')
            ->withCount(['orders'])
            ->orderBy('orders_count', 'DESC')
            ->take(15)
            ->get();
        //end

        //feature products finding based on selling
        $featured_products = Product::with(['reviews'])->active()
            ->where('featured', 1)
            ->withCount(['order_details'])
            ->orderBy('order_details_count', 'DESC')
            ->take(12)
            ->get();
        //end

        $latest_products = Product::with(['reviews', 'brand'])
            ->active()
            ->orderBy('created_at', 'desc')
            ->inRandomOrder()
            ->take(6)
            ->get();

        $categories = Category::with('childes')
            ->where('position', 0)
            ->orderBy('name', 'ASC')
            ->inRandomOrder()
            ->take(10)
            ->get();

        $brands = Brand::take(15)->get();

        //best sell product
        $bestSellProduct = OrderDetail::with('product.reviews')
            ->whereHas('product', function ($query) {
                $query->active();
            })
            ->select('product_id', DB::raw('COUNT(product_id) as count'))
            ->groupBy('product_id')
            ->orderBy("count", 'desc')
            ->take(4)
            ->get();

        //Top rated
        $topRated = Review::with('product')
            ->whereHas('product', function ($query) {
                $query->active();
            })
            ->select('product_id', DB::raw('AVG(rating) as count'))
            ->groupBy('product_id')
            ->orderBy("count", 'desc')
            ->take(4)
            ->get();

        if ($bestSellProduct->count() == 0) {
            $bestSellProduct = $latest_products;
        }

        if ($topRated->count() == 0) {
            $topRated = $bestSellProduct;
        }

        $deal_of_the_day = DealOfTheDay::join('products', 'products.id', '=', 'deal_of_the_days.product_id')
            ->select('deal_of_the_days.*', 'products.unit_price')
            ->where('deal_of_the_days.status', 1)
            ->first();

        $look_books = LookBook::where('status', 1)->latest()->get();

        return view(
            'front.index',
            compact(
                'banners',
                'featured_products',
                'topRated',
                'bestSellProduct',
                'latest_products',
                'categories',
                'brands',
                'deal_of_the_day',
                'top_sellers',
                'home_categories',
                'shop_by_style',
                'latest_blogs',
                'look_books'
            )
        );
    }

    public function flash_deals($id)
    {
        $deal = FlashDeal::with(['products.product.reviews'])->where(['id' => $id, 'status' => 1])->whereDate('start_date', '<=', date('Y-m-d'))->whereDate('end_date', '>=', date('Y-m-d'))->first();

        $discountPrice = FlashDealProduct::with(['product'])->get()->map(function ($data) {
            return [
                'discount' => $data->discount,
                'sellPrice' => $data->product->unit_price,
                'discountedPrice' => $data->product->unit_price - $data->discount,

            ];
        })->toArray();
        // dd($deal->toArray());

        if (isset($deal)) {
            return view('web-views.deals', compact('deal', 'discountPrice'));
        }
        Toastr::warning('no such deal found!');
        return back();
    }

    public function search_shop(Request $request)
    {
        $key = explode(' ', $request['shop_name']);
        $sellers = Shop::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
            }
        })->whereHas('seller', function ($query) {
            return $query->where(['status' => 'approved']);
        })->paginate(30);

        return view('front.accessories', compact('sellers'));
    }

    public function all_categories()
    {
        $categories = Category::all();
        return view('web-views.categories', compact('categories'));
    }

    public function categories_by_category($id)
    {
        $category = Category::with(['childes.childes'])->where('id', $id)->first();
        return response()->json([
            'view' => view('web-views.partials._category-list-ajax', compact('category'))->render(),
        ]);
    }

    public function all_brands()
    {
        $brands = [];
        $previousalphabet = null;
        $get_all_brands = Brand::where(['status' => 1])->orderBy('name', 'ASC')->get();
        foreach ($get_all_brands as $key => $brand) {
            $firstalphabet = substr(strtoupper($brand->name), 0, 1);

            for ($i = 48; $i <= 57; $i++) {
                if (chr($i) == $firstalphabet) {
                    $brands['0-9'][] = $brand->toArray();
                }
            }

            for ($i = 65; $i <= 90; $i++) {
                if (chr($i) == $firstalphabet) {
                    $brands[$firstalphabet][] = $brand->toArray();
                }
            }
        }

        return view('web-views.brands', compact('brands'));
    }


    public function all_sellers()
    {
        $sellers = Shop::paginate(30);
        return view('web-views.sellers', compact('sellers'));
    }

    public function seller_profile($id)
    {
        $seller_info = Seller::find($id);
        return view('web-views.seller-profile', compact('seller_info'));
    }

    public function searched_products(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Product name is required!',
        ]);

        $result = ProductManager::search_products($request['name']);
        $products = $result['products'];

        return response()->json([
            'result' => view('web-views.partials._search-result', compact('products'))->render(),
        ]);
    }

    public function checkout()
    {
        $shipping_methods = ShippingMethod::where(['status' => 1, 'creator_type' => 'admin'])->get();
        $shipping_addresses = ShippingAddress::where('customer_id', auth('customer')->id())->get();
        $customerDetail = User::where('id', auth('customer')->id())->first();
        if (session()->has('cart') && count(session('cart')) > 0) {
            return view('front.shipment', compact('shipping_methods', 'shipping_addresses','customerDetail'));
        }
        Toastr::info('No items in your basket!');
        return redirect('/');
    }

//    public function checkout_details()
//    {
//        if (session()->has('shipping_method_id') == false) {
//            Toastr::info('Select shipping method first!');
//            return redirect('shop-cart');
//        }
//
//        if (session()->has('cart') && count(session('cart')) > 0) {
//            return view('web-views.checkout');
//        }
//        Toastr::info('No items in your basket!');
//        return redirect('/');
//    }

//    public function checkout_shipping(Request $request)
//    {
//        if (session()->has('shipping_method_id') == false) {
//            Toastr::info('Select shipping method first!');
//            return redirect('shop-cart');
//        }
//
//        if (session()->has('cart') && count(session('cart')) > 0) {
//            return view('web-views.checkout-shipping');
//        }
//        Toastr::info('No items in your basket!');
//        return redirect('/');
//    }

    public function checkout_payment()
    {

        if (session()->has('shipping_method_id') == false) {
            Toastr::info('Select shipping method first!');
            return redirect('checkout');
        }

        if (session()->has('order_id')) {
            Order::where(['id' => session('order_id')])->delete();
            OrderDetail::where(['order_id' => session('order_id')])->delete();
            $order_id = session('order_id');
        } else {
            $order_id = 100000 + Order::all()->count() + 1;

        }
        $customer_info = session('customer_info');
        $discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;

        try {
            $or = [
                'id' => $order_id,
                'customer_id' => auth('customer')->id(),
                'customer_type' => 'customer',
                'payment_status' => 'unpaid',
                'order_status' => 'pending',
                'payment_method' => 'not choosen yet',
                'transaction_ref' => null,
                'discount_amount' => $discount,
                'discount_type' => $discount == 0 ? null : 'coupon_discount',
                'order_amount' => CartManager::cart_grand_total(session('cart')) - $discount,
                'shipping_address' => $customer_info['address_id'],
                'created_at' => now(),
                'updated_at' => now()
            ];

            $order_id = DB::table('orders')->insertGetId($or);

            foreach (session('cart') as $c) {
                $product = Product::where(['id' => $c['id']])->first();
                $or_d = [
                    'order_id' => $order_id,
                    'product_id' => $c['id'],
                    'seller_id' => $product->added_by == 'seller' ? $product->user_id : '0',
                    'product_details' => $product,
                    'qty' => $c['quantity'],
                    'price' => $c['price'],
                    'tax' => $c['tax'] * $c['quantity'],
                    'discount' => $c['discount'] * $c['quantity'],
                    'discount_type' => 'discount_on_product',
                    'variant' => $c['variant'],
                    'variation' => json_encode($c['variations']),
                    'delivery_status' => 'pending',
                    'shipping_method_id' => $c['shipping_method_id'],
                    'payment_status' => 'unpaid',
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                if ($c['variant'] != null) {
                    $type = $c['variant'];
                    $var_store = [];
                    foreach (json_decode($product['variation'], true) as $var) {
                        if ($type == $var['type']) {
                            $var['qty'] -= $c['quantity'];
                        }
                        array_push($var_store, $var);
                    }
                    Product::where(['id' => $product['id']])->update([
                        'variation' => json_encode($var_store),
                    ]);
                }

                Product::where(['id' => $product['id']])->update([
                    'current_stock' => $product['current_stock'] - $c['quantity']
                ]);

                DB::table('order_details')->insert($or_d);
            }

            session()->put('order_id', $order_id);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());
            return back();
        }

        if (session()->has('customer_info') && session()->has('cart') && count(session('cart')) > 0) {
            return view('web-views.checkout-payment');
        }

        Toastr::error('Incomplete info!');
        return back();
    }

//    public function checkout_payment()
//    {
//        if (session()->has('shipping_method_id') == false) {
//            Toastr::info('Select shipping method first!');
//            return redirect('checkout');
//        }
//
//        if (session()->has('order_id')) {
//            Order::where(['id' => session('order_id')])->delete();
//            OrderDetail::where(['order_id' => session('order_id')])->delete();
//            $order_id = session('order_id');
//        } else {
//            $order_id = 100000 + Order::all()->count() + 1;
//        }
//
//        $customer_info = session('customer_info');
//        $discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
//
//        try {
//            $or = [
//                'id' => $order_id,
//                'customer_id' => auth('customer')->id(),
//                'customer_type' => 'customer',
//                'payment_status' => 'unpaid',
//                'order_status' => 'pending',
//                'payment_method' => 'not choosen yet',
//                'transaction_ref' => null,
//                'discount_amount' => $discount,
//                'discount_type' => $discount == 0 ? null : 'coupon_discount',
//                'order_amount' => CartManager::cart_grand_total(session('cart')) - $discount,
//                'shipping_address' => $customer_info['address_id'],
//                'created_at' => now(),
//                'updated_at' => now()
//            ];
//
//            $order_id = DB::table('orders')->insertGetId($or);
//
//            foreach (session('cart') as $c) {
//                $product = Product::where(['id' => $c['id']])->first();
//                $or_d = [
//                    'order_id' => $order_id,
//                    'product_id' => $c['id'],
//                    'seller_id' => $product->added_by == 'seller' ? $product->user_id : '0',
//                    'product_details' => $product,
//                    'qty' => $c['quantity'],
//                    'price' => $c['price'],
//                    'tax' => $c['tax'] * $c['quantity'],
//                    'discount' => $c['discount'] * $c['quantity'],
//                    'discount_type' => 'discount_on_product',
//                    'variant' => $c['variant'],
//                    'variation' => json_encode($c['variations']),
//                    'delivery_status' => 'pending',
//                    'shipping_method_id' => $c['shipping_method_id'],
//                    'payment_status' => 'unpaid',
//                    'created_at' => now(),
//                    'updated_at' => now()
//                ];
//
//                if ($c['variant'] != null) {
//                    $type = $c['variant'];
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
//
//                Product::where(['id' => $product['id']])->update([
//                    'current_stock' => $product['current_stock'] - $c['quantity']
//                ]);
//
//                DB::table('order_details')->insert($or_d);
//            }
//
//            session()->put('order_id', $order_id);
//        } catch (\Exception $e) {
//            Toastr::error('Invalid informations.');
//            return back();
//        }
//
//        if (session()->has('customer_info') && session()->has('cart') && count(session('cart')) > 0) {
//            return view('web-views.checkout-payment');
//        }
//
//        Toastr::error('Incomplete info!');
//        return back();
//    }

    public function checkout_complete(Request $request)
    {
        if (session()->has('shipping_method_id') == false) {
            Toastr::info('Select shipping method first!');
            return redirect('shop-cart');
        }

        if (session()->has('cart') == false || count(session('cart')) == 0) {
            Toastr::info('Your cart is empty.');
            return redirect()->route('home');
        }

        try {
            $fcm_token = User::where(['id' => auth('customer')->id()])->first()->cm_firebase_token;
            $value = \App\CPU\Helpers::order_status_update_message('pending');
            if ($value) {
                $data = [
                    'title' => 'Order',
                    'description' => $value,
                    'order_id' => session('order_id'),
                    'image' => '',
                ];
                Helpers::send_push_notif_to_device($fcm_token, $data);
            }
        } catch (\Exception $e) {
            Toastr::error('FCM token config issue.');
        }

        $order_id = session('order_id');
        Order::where(['id' => $order_id])->update(['payment_method' => $request['payment_method']]);
        try {
            $seller_ids = OrderDetail::Where(['order_id' => $order_id])->pluck('seller_id')->toArray();
            foreach (array_unique($seller_ids) as $seller_id) {
                if ($seller_id == 0) {
                    $email = Admin::where(['admin_role_id' => 1])->first()->email;
                } else {
                    $email = Seller::where('id', $seller_id)->first()->email;
                }
                Mail::to($email)->send(new \App\Mail\OrderReceivedNotifySeller(session('order_id')));
            }
            Mail::to(auth('customer')->user()->email)->send(new \App\Mail\OrderPlaced(session('order_id')));
        } catch (\Exception $mail_exception) {
            Toastr::error('Invalid mail or configuration.');
        }

        session()->forget('cart');
        session()->forget('coupon_code');
        session()->forget('coupon_discount');
        session()->forget('payment_method');
        session()->forget('customer_info');
        session()->forget('shipping_method_id');
        session()->forget('order_id');

        return view('web-views.checkout-complete', compact('order_id'));
    }

    public function shop_cart()
    {
        if (session()->has('cart') && count(session('cart')) > 0) {
            $productIds = [];
            $categoriesIds = [];

            foreach (session('cart') as $key => $cartItem) {
                $productIds[] = $cartItem['id'];
                $categoriesIds[] = Product::find($cartItem['id'])->category_ids;
            }

            $related_products = Product::with(['reviews', 'brand'])
                ->active()
                ->whereIn('category_ids', $categoriesIds)
                ->whereNotIn('id', $productIds)
                ->limit(4)
                ->inRandomOrder()
                ->get();

            $recent_products = Product::with(['reviews', 'brand'])
                ->active()
                ->orderBy('id', 'desc')
                ->inRandomOrder()
                ->limit(4)
                ->get();

            return view('web-views.shop-cart', compact('related_products', 'recent_products'));
        }
        Toastr::info('No items in your basket!');
        return redirect('/');
    }

    public function shop(Request $request,$search_category = null,$sub_category = null)
    {

//        $category = '';
//
//        if (isset($request->catId)) {
//            $category = Category::with('childes')
//                ->where('id', $request->catId)
//                ->where('parent_id', 0)
//                ->first();
//        }
//

//
        $fetched = Product::active()->paginate(20);

        $products = Product::active()->get();

        if($search_category || $sub_category){
            $product_ids = [];
            foreach ($products as $product) {

                $productCategory = json_decode($product['category_ids'], true);

                if($search_category && $sub_category){
                    if(!empty($productCategory[0]) && !empty($productCategory[1]) && $productCategory[0]['slug'] == $search_category && $productCategory[1]['slug'] == $sub_category){
                        array_push($product_ids, $product['id']);
                    }
                }else if($search_category){
                    if(!empty($productCategory[0]) && $productCategory[0]['slug'] == $search_category){
                        array_push($product_ids, $product['id']);
                    }
                }

//                if($search_category) var_dump($productCategory[0]['slug'].' '.$search_category);
//                if($sub_category) var_dump($productCategory[1]['slug'].' '.$sub_category);

//                if(!empty($search_category) && !empty($productCategory[0]) && $productCategory[0]['slug'] == $search_category){
//                    array_push($product_ids, $product['id']);
//                }
//                if($sub_category && !empty($productCategory[1]) && $productCategory[1]['slug'] == $sub_category){
//                    array_push($product_ids, $product['id']);
//                }

//                foreach ( as $category) {
//                    var_dump($category);
//                    if ($category['slug'] == $search_category) {
//                        array_push($product_ids, $product['id']);
//                    }
//                }
            }



            $products = Product::with(['reviews'])->whereIn('id', array_unique($product_ids))->get();
        }



//        $product_ids = [];
//        foreach ($products as $product) {
//            foreach (json_decode($product['category_ids'], true) as $category) {
//                if ($category['id'] == $request['catId']) {
//                    array_push($product_ids, $product['id']);
//                }
//            }
//        }
//
//        if (count($product_ids) > 0) {
//            $query = Product::with(['reviews'])->whereIn('id', $product_ids);
//        } else {
//            $query = Product::with(['reviews']);
//        }
//
//        if ($request['sort_by'] == 'latest') {
//            $fetched = $query->latest();
//        } elseif ($request['sort_by'] == 'low-high') {
//            $fetched = $query->orderBy('unit_price', 'ASC');
//        } elseif ($request['sort_by'] == 'high-low') {
//            $fetched = $query->orderBy('unit_price', 'DESC');
//        } elseif ($request['sort_by'] == 'a-z') {
//            $fetched = $query->orderBy('name', 'ASC');
//        } elseif ($request['sort_by'] == 'z-a') {
//            $fetched = $query->orderBy('name', 'DESC');
//        } else {
//            $fetched = $query;
//        }
//
//        $products = $fetched->paginate(10);

        $mainCategory = '';

        $getCategories = Category::with(['childes' => function ($query) {
            $query->with('products')->withCount('products');
        }])
            ->where('parent_id', 0)
//            ->orderBy('name', 'ASC')
            ->get();

        if ($request['sort_by'] == null) {
            $request['sort_by'] = 'latest';
        }

        if ($request['data_from'] == 'category') {

            $getCategory = Category::with('parent')->where('id', $request['id'])->first();

            if ($getCategory->parent) {
                $mainCategory = Category::with(['childes' => function ($query) {
                    $query->orderBy('created_at', 'DESC')->limit(4);
                }])
                    ->where('id', $getCategory->parent->id)
                    ->first();
            } else {
                $mainCategory = Category::with(['childes' => function ($query) {
                    $query->orderBy('created_at', 'DESC')->limit(4);
                }])
                    ->where('id', $request['id'])
                    ->first();
            }

            $products = Product::active()->get();
            $product_ids = [];
            foreach ($products as $product) {
                foreach (json_decode($product['category_ids'], true) as $category) {
                    if ($category['id'] == $request['id']) {
                        array_push($product_ids, $product['id']);
                    }
                }
            }

            $query = Product::with(['reviews'])->whereIn('id', $product_ids);
            if ($request['sort_by'] == 'latest') {
                $fetched = $query->latest();
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

        if ($request['data_from'] == 'brand') {
            $query = Product::with(['reviews'])->active()->where('brand_id', $request['id']);
            if ($request['sort_by'] == 'latest') {
                $fetched = $query->latest();
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }

        }

        if ($request['data_from'] == 'sale') {
            $query = Product::with(['reviews'])->active()->where('discount', '>', 0)->orderBy('id', 'DESC');
            if ($request['sort_by'] == 'latest') {
                $fetched = $query;
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

        if ($request['data_from'] == 'latest') {
            $query = Product::with(['reviews'])->active()->orderBy('id', 'DESC');
            if ($request['sort_by'] == 'latest') {
                $fetched = $query;
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

//        if ($request['data_from'] == 'top-rated') {
//            $reviews = Review::select('product_id', DB::raw('AVG(rating) as count'))
//                ->groupBy('product_id')
//                ->orderBy("count", 'desc')->get();
//            $product_ids = [];
//            foreach ($reviews as $review) {
//                array_push($product_ids, $review['product_id']);
//            }
//            $query = Product::with(['reviews'])->whereIn('id', $product_ids);
//
//            if ($request['sort_by'] == 'latest') {
//                $fetched = $query;
//            } elseif ($request['sort_by'] == 'low-high') {
//                $fetched = $query->orderBy('unit_price', 'ASC');
//            } elseif ($request['sort_by'] == 'high-low') {
//                $fetched = $query->orderBy('unit_price', 'DESC');
//            } elseif ($request['sort_by'] == 'a-z') {
//                $fetched = $query->orderBy('name', 'ASC');
//            } elseif ($request['sort_by'] == 'z-a') {
//                $fetched = $query->orderBy('name', 'DESC');
//            } else {
//                $fetched = $query;
//            }
//        }

//        if ($request['data_from'] == 'best-selling') {
//            $details = OrderDetail::with('product')
//                ->select('product_id', DB::raw('COUNT(product_id) as count'))
//                ->groupBy('product_id')
//                ->orderBy("count", 'desc')
//                ->get();
//            $product_ids = [];
//            foreach ($details as $detail) {
//                array_push($product_ids, $detail['product_id']);
//            }
//            $query = Product::with(['reviews'])->active()->whereIn('id', $product_ids);
//
//            if ($request['sort_by'] == 'latest') {
//                $fetched = $query;
//            } elseif ($request['sort_by'] == 'low-high') {
//                $fetched = $query->orderBy('unit_price', 'ASC');
//            } elseif ($request['sort_by'] == 'high-low') {
//                $fetched = $query->orderBy('unit_price', 'DESC');
//            } elseif ($request['sort_by'] == 'a-z') {
//                $fetched = $query->orderBy('name', 'ASC');
//            } elseif ($request['sort_by'] == 'z-a') {
//                $fetched = $query->orderBy('name', 'DESC');
//            } else {
//                $fetched = $query;
//            }
//        }

//        if ($request['data_from'] == 'most-favorite') {
//            $details = Wishlist::with('product')
//                ->select('product_id', DB::raw('COUNT(product_id) as count'))
//                ->groupBy('product_id')
//                ->orderBy("count", 'desc')
//                ->get();
//            $product_ids = [];
//            foreach ($details as $detail) {
//                array_push($product_ids, $detail['product_id']);
//            }
//            $query = Product::with(['reviews'])->active()->whereIn('id', $product_ids);
//
//            if ($request['sort_by'] == 'latest') {
//                $fetched = $query;
//            } elseif ($request['sort_by'] == 'low-high') {
//                $fetched = $query->orderBy('unit_price', 'ASC');
//            } elseif ($request['sort_by'] == 'high-low') {
//                $fetched = $query->orderBy('unit_price', 'DESC');
//            } elseif ($request['sort_by'] == 'a-z') {
//                $fetched = $query->orderBy('name', 'ASC');
//            } elseif ($request['sort_by'] == 'z-a') {
//                $fetched = $query->orderBy('name', 'DESC');
//            } else {
//                $fetched = $query;
//            }
//
//        }

//        if ($request['data_from'] == 'featured') {
//            $query = Product::with(['reviews'])->active()->where('featured', 1);
//            if ($request['sort_by'] == 'latest') {
//                $fetched = $query->latest();
//            } elseif ($request['sort_by'] == 'low-high') {
//                $fetched = $query->orderBy('unit_price', 'ASC');
//            } elseif ($request['sort_by'] == 'high-low') {
//                $fetched = $query->orderBy('unit_price', 'DESC');
//            } elseif ($request['sort_by'] == 'a-z') {
//                $fetched = $query->orderBy('name', 'ASC');
//            } elseif ($request['sort_by'] == 'z-a') {
//                $fetched = $query->orderBy('name', 'DESC');
//            } else {
//                $fetched = $query;
//            }
//        }


        $latest_products = Product::with(['reviews', 'brand'])
            ->active()
            ->orderBy('created_at', 'desc')
            ->inRandomOrder()
            ->limit(6)
            ->get();
        if ($request['data_from'] == 'search') {
            $key = explode(' ', $request['name']);
            $query = Product::with(['reviews'])->active()->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            });

            if ($request['sort_by'] == 'latest') {
                $fetched = $query->latest();
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

//        $products = $fetched->paginate(20);
//        return $products;

        return view('front.accessories', compact(
            'getCategories',
            'mainCategory',
            'products',
            'latest_products',
            'search_category','sub_category'
        ));
    }

    //for seller Shop

    public function seller_shop(Request $request, $id)
    {
        //review+rating+order count
        $products = Product::active()
            ->when($id == 0, function ($query) {
                return $query->where(['added_by' => 'admin']);
            })
            ->when($id != 0, function ($query) use ($id) {
                return $query->where(['added_by' => 'seller'])
                    ->where('user_id', $id);
            })
            ->paginate(12);

        $reviews = [];
        foreach ($products as $product) {
            $x = Review::where('product_id', $product->id)->get();
            array_push($reviews, $x->first());
        }
        $total_review = count(array_filter($reviews));

        $ratings = 0;
        foreach ($reviews as $review) {
            if ($review != null) {
                $ratings .= $review->rating;
            }
        }
        if (count(array_filter($reviews)) > 0) {
            $total_rating = $ratings / count(array_filter($reviews));
        } else {
            $total_rating = $ratings;
        }

        $orders = [];
        foreach ($products as $product) {
            $x = OrderDetail::where('product_id', $product->id)->get();
            array_push($orders, $x->first());
        }
        $total_order = count(array_filter($orders));
        //end

        //finding category ids
        $products = Product::active()
            ->when($id == 0, function ($query) {
                return $query->where(['added_by' => 'admin']);
            })
            ->when($id != 0, function ($query) use ($id) {
                return $query->where(['added_by' => 'seller'])
                    ->where('user_id', $id);
            })
            ->paginate(12);

        $category_info = [];
        foreach ($products as $product) {
            array_push($category_info, $product['category_ids']);
        }

        $category_info_decoded = [];
        foreach ($category_info as $category_info) {
            array_push($category_info_decoded, json_decode($category_info));
        }

        $category_ids = [];
        foreach ($category_info_decoded as $category_info_decoded) {
            foreach ($category_info_decoded as $category_info_decoded) {
                array_push($category_ids, $category_info_decoded->id);
            }
        }

        $categories = [];
        foreach ($category_ids as $category_id) {
            $category = Category::with(['childes.childes'])->where('position', 0)->find($category_id);
            if ($category != null) {
                array_push($categories, $category);
            }
        }
        $categories = array_unique($categories);
        //end

        //products
        if ($request->product_name) {
            $products = Product::active()
                ->when($id == 0, function ($query) {
                    return $query->where(['added_by' => 'admin']);
                })
                ->when($id != 0, function ($query) use ($id) {
                    return $query->where(['added_by' => 'seller'])
                        ->where('user_id', $id);
                })
                ->where('name', 'like', $request->product_name . '%')
                ->paginate(12);
        } elseif ($request->category_id) {
            $products = Product::active()
                ->when($id == 0, function ($query) {
                    return $query->where(['added_by' => 'admin']);
                })
                ->when($id != 0, function ($query) use ($id) {
                    return $query->where(['added_by' => 'seller'])
                        ->where('user_id', $id);
                })
                ->whereJsonContains('category_ids', [
                    ['id' => strval($request->category_id)],
                ])->paginate(12);
        } else {
            $products = Product::active()
                ->when($id == 0, function ($query) {
                    return $query->where(['added_by' => 'admin']);
                })
                ->when($id != 0, function ($query) use ($id) {
                    return $query->where(['added_by' => 'seller'])
                        ->where('user_id', $id);
                })
                ->paginate(12);
        }
        //end

        if ($id == 0) {
            $shop = [
                'id' => 0,
                'name' => 'SixValley',
            ];
        } else {
            $shop = Shop::where('seller_id', $id)->first();
        }

        return view('web-views.shop-page', compact('products', 'shop', 'categories'))
            ->with('seller_id', $id)
            ->with('total_review', $total_review)
            ->with('total_rating', $total_rating)
            ->with('total_order', $total_order);
    }

    //ajax filter (category based)
    public function seller_shop_product(Request $request, $id)
    {
        $products = Product::active()->with('shop')->where(['added_by' => 'seller'])
            ->where('user_id', $id)
            ->whereJsonContains('category_ids', [
                ['id' => strval($request->category_id)],
            ])
            ->paginate(12);
        $shop = Shop::where('seller_id', $id)->first();
        if ($request['sort_by'] == null) {
            $request['sort_by'] = 'latest';
        }

        return response()->json([
            'view' => view('web-views.products._ajax-products', compact('products'))->render(),
            //'paginator' => view('web-views.products._ajax-paginator', compact('data', 'page'))->render(),
        ], 200);

        return '<h1>Successful</h1>';

        return view('web-views.shop-page', compact('products', 'shop'))->with('seller_id', $id);
    }

    public function quick_view(Request $request)
    {
        $product = ProductManager::get_product($request->product_id);
        $order_details = OrderDetail::where('product_id', $product->id)->get();
        $wishlists = Wishlist::where('product_id', $product->id)->get();
        $countOrder = count($order_details);
        $countWishlist = count($wishlists);
        $relatedProducts = Product::with(['reviews'])->where('category_ids', $product->category_ids)->where('id', '!=', $product->id)->limit(12)->get();
        return response()->json([
            'success' => 1,
            'view' => view('web-views.partials._quick-view-data', compact('product', 'countWishlist', 'countOrder', 'relatedProducts'))->render(),
        ]);
    }

    public function productDetails($slug)
    {
        if (!session()->has('products_you_view')) {
            session()->put('products_you_view', []);
        }
        $product = Product::active()->with(['reviews'])->where('slug', $slug)->first();

        if ($product != null) {
            if (!in_array($product->id, session()->get('products_you_view'))) {
                session()->push('products_you_view', $product->id);
            }
            $countOrder = OrderDetail::where('product_id', $product->id)->count();
            $countWishlist = Wishlist::where('product_id', $product->id)->count();
            $productsYouViewed = Product::with(['reviews', 'brand'])
                ->active()
                ->whereIn('id', session()->get('products_you_view'))
                ->limit(4)
                ->inRandomOrder()
                ->get();

            $relatedProducts = Product::with(['reviews', 'brand'])
                ->active()
                ->where('category_ids', $product->category_ids)
                ->where('id', '!=', $product->id)
                ->limit(4)
                ->inRandomOrder()
                ->get();
            $deal_of_the_day = DealOfTheDay::where('product_id', $product->id)->where('status', 1)->first();

//            return $product;
            return view('front.productdetail',
                compact(
                    'product',
                    'countWishlist',
                    'countOrder',
                    'relatedProducts',
                    'deal_of_the_day',
                    'productsYouViewed'
                )
            );
        }

        Toastr::error('Product not found!');
        return back();
    }

    public function product($slug)
    {

        $product = Product::active()->with(['reviews'])->where('slug', $slug)->first();
        if ($product != null) {
            $countOrder = OrderDetail::where('product_id', $product->id)->count();
            $countWishlist = Wishlist::where('product_id', $product->id)->count();
            $relatedProducts = Product::with(['reviews'])->active()->where('category_ids', $product->category_ids)->where('id', '!=', $product->id)->limit(12)->get();
            $deal_of_the_day = DealOfTheDay::where('product_id', $product->id)->where('status', 1)->first();
            return view('web-views.products.details', compact('product', 'countWishlist', 'countOrder', 'relatedProducts', 'deal_of_the_day'));
        }

        Toastr::error('Product not found!');
        return back();
    }

    public function products(Request $request)
    {
        if ($request['sort_by'] == null) {
            $request['sort_by'] = 'latest';
        }

        if ($request['data_from'] == 'category') {
            $products = Product::active()->get();
            $product_ids = [];
            foreach ($products as $product) {
                foreach (json_decode($product['category_ids'], true) as $category) {
                    if ($category['id'] == $request['id']) {
                        array_push($product_ids, $product['id']);
                    }
                }
            }

            $query = Product::with(['reviews'])->whereIn('id', $product_ids);
            if ($request['sort_by'] == 'latest') {
                $fetched = $query->latest();
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

        if ($request['data_from'] == 'brand') {
            $query = Product::with(['reviews'])->active()->where('brand_id', $request['id']);
            if ($request['sort_by'] == 'latest') {
                $fetched = $query->latest();
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }

        }

        if ($request['data_from'] == 'latest') {
            $query = Product::with(['reviews'])->active()->orderBy('id', 'DESC');
            if ($request['sort_by'] == 'latest') {
                $fetched = $query;
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

        if ($request['data_from'] == 'top-rated') {
            $reviews = Review::select('product_id', DB::raw('AVG(rating) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')->get();
            $product_ids = [];
            foreach ($reviews as $review) {
                array_push($product_ids, $review['product_id']);
            }
            $query = Product::with(['reviews'])->whereIn('id', $product_ids);

            if ($request['sort_by'] == 'latest') {
                $fetched = $query;
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

        if ($request['data_from'] == 'best-selling') {
            $details = OrderDetail::with('product')
                ->select('product_id', DB::raw('COUNT(product_id) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')
                ->get();
            $product_ids = [];
            foreach ($details as $detail) {
                array_push($product_ids, $detail['product_id']);
            }
            $query = Product::with(['reviews'])->active()->whereIn('id', $product_ids);

            if ($request['sort_by'] == 'latest') {
                $fetched = $query;
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

        if ($request['data_from'] == 'most-favorite') {
            $details = Wishlist::with('product')
                ->select('product_id', DB::raw('COUNT(product_id) as count'))
                ->groupBy('product_id')
                ->orderBy("count", 'desc')
                ->get();
            $product_ids = [];
            foreach ($details as $detail) {
                array_push($product_ids, $detail['product_id']);
            }
            $query = Product::with(['reviews'])->active()->whereIn('id', $product_ids);

            if ($request['sort_by'] == 'latest') {
                $fetched = $query;
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }

        }

        if ($request['data_from'] == 'featured') {
            $query = Product::with(['reviews'])->active()->where('featured', 1);
            if ($request['sort_by'] == 'latest') {
                $fetched = $query->latest();
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

        if ($request['data_from'] == 'search') {
            $key = explode(' ', $request['name']);
            $query = Product::with(['reviews'])->active()->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            });

            if ($request['sort_by'] == 'latest') {
                $fetched = $query->latest();
            } elseif ($request['sort_by'] == 'low-high') {
                $fetched = $query->orderBy('unit_price', 'ASC');
            } elseif ($request['sort_by'] == 'high-low') {
                $fetched = $query->orderBy('unit_price', 'DESC');
            } elseif ($request['sort_by'] == 'a-z') {
                $fetched = $query->orderBy('name', 'ASC');
            } elseif ($request['sort_by'] == 'z-a') {
                $fetched = $query->orderBy('name', 'DESC');
            } else {
                $fetched = $query;
            }
        }

        if ($request['min_price'] != null || $request['max_price'] != null) {
            $fetched = $fetched->whereBetween('unit_price', [Helpers::convert_currency_to_usd($request['min_price']), Helpers::convert_currency_to_usd($request['max_price'])]);
        }

        $products = $fetched->paginate(20);

        $data = [
            'id' => $request['id'],
            'name' => $request['name'],
            'data_from' => $request['data_from'],
            'sort_by' => $request['sort_by'],
            'page_no' => $request['page'],
            'min_price' => $request['min_price'],
            'max_price' => $request['max_price'],
            'page_number' => $products->lastPage(),
        ];

        if ($request->ajax()) {
            $page = $request['page'];
            return response()->json([
                'view' => view('web-views.products._ajax-products', compact('products'))->render(),
                'paginator' => view('web-views.products._ajax-paginator', compact('data', 'page'))->render(),
            ], 200);
        }
        if ($request['data_from'] == 'category') {
            $data['brand_name'] = Category::find((int)$request['id'])->name;
        }
        if ($request['data_from'] == 'brand') {
            $data['brand_name'] = Brand::find((int)$request['id'])->name;
        }

        return view('web-views.products.view', compact('products', 'data'), $data);
    }

    public function viewWishlist()
    {
        $wishlists = Wishlist::with('product')
            ->where('customer_id', auth('customer')->id())
            ->paginate(10);
        return view('front.bookmark', compact('wishlists'));
    }

    public function storeWishlist($productSlug)
    {
        if (auth('customer')->check()) {
            $product = Product::where('slug', $productSlug)->first();
            if (!$product) {
                Toastr::error('No product found!');
                return back();
            }
            $wishlist = Wishlist::where('customer_id', auth('customer')->id())
                ->where('product_id', $product->id)
                ->first();
            if (empty($wishlist)) {
                $wishlist = new Wishlist;
                $wishlist->customer_id = auth('customer')->id();
                $wishlist->product_id = $product->id;
                $wishlist->save();
                session()->put('wish_list',
                    Wishlist::where('customer_id', auth('customer')
                        ->user()->id)
                        ->pluck('product_id')
                        ->toArray()
                );
                Toastr::info('Product has been added to wishlist!');
                return redirect()->back();
            } else {
                Toastr::info('Product already added to wishlist!');
                return redirect()->back();
            }
        } else {
            Toastr::error('Please login to add wishlist!');
            return back();
        }
    }

    public function deleteWishlist($productSlug)
    {
        $product = Product::where('slug', $productSlug)->first();
        if (!$product) {
            Toastr::error('No product found!');
            return back();
        }
        Wishlist::where(['product_id' => $product->id, 'customer_id' => auth('customer')->id()])->delete();
        Toastr::info('Product has been remove from wishlist!');
        return redirect()->back();
    }

    public function deleteAllWishlist()
    {
        $product = Wishlist::where(['customer_id' => auth('customer')->id()])->get();
        if (empty($product)) {
            Toastr::error('No Bookmark found!');
            return back();
        }
        Wishlist::where(['customer_id' => auth('customer')->id()])->delete();
        Toastr::info('Products has been remove from wishlist!');
        return redirect()->back();
    }

//    public function storeWishlist(Request $request)
//    {
//        if ($request->ajax()) {
//            if (auth('customer')->check()) {
//                $wishlist = Wishlist::where('customer_id', auth('customer')->id())->where('product_id', $request->product_id)->first();
//                if (empty($wishlist)) {
//
//                    $wishlist = new Wishlist;
//                    $wishlist->customer_id = auth('customer')->id();
//                    $wishlist->product_id = $request->product_id;
//                    $wishlist->save();
//
//                    $countWishlist = Wishlist::where('customer_id', auth('customer')->id())->get();
//                    $data = "Product has been added to wishlist";
//
//                    $product_count = Wishlist::where(['product_id' => $request->product_id])->count();
//                    session()->put('wish_list', Wishlist::where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray());
//                    return response()->json(['success' => $data, 'value' => 1, 'count' => count($countWishlist), 'id' => $request->product_id, 'product_count' => $product_count]);
//                } else {
//                    $data = "Product already added to wishlist";
//                    return response()->json(['error' => $data, 'value' => 2]);
//                }
//
//            } else {
//                $data = "Please login first";
//                return response()->json(['error' => $data, 'value' => 0]);
//            }
//        }
//    }

//    public function deleteWishlist(Request $request)
//    {
//        Wishlist::where(['product_id' => $request['id'], 'customer_id' => auth('customer')->id()])->delete();
//        $data = "Product has been remove from wishlist!";
//        $wishlists = Wishlist::where('customer_id', auth('customer')->id())->get();
//        session()->put('wish_list', Wishlist::where('customer_id', auth('customer')->user()->id)->pluck('product_id')->toArray());
//        return response()->json([
//            'success' => $data,
//            'count' => count($wishlists),
//            'id' => $request->id,
//            'wishlist' => view('web-views.partials._wish-list-data', compact('wishlists'))->render(),
//        ]);
//    }

    //for HelpTopic
    public function helpTopic()
    {
        $helps = HelpTopic::Status()->latest()->get();
        return view('web-views.help-topics', compact('helps'));
    }

    //for Contact US Page
    public function contact_us()
    {
        $data['help_topics'] = HelpTopic::get();
        return view('front.contactus',$data);
    }

    public function contact_us_store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:32',
            'last_name' => 'required|string|max:32',
            'phone_number' => 'required|max:20',
            'subject' => 'required|string|max:191',
            'email' => 'required|email|max:128|regex:/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/',
            'message' => 'required|max:2000',
        ], [
            'email.regex' => 'Please provide a valid email'
        ]);

        $contact = new Contact;
        $contact->name = $request->first_name . ' ' . $request->last_name;
        $contact->email = $request->email;
        $contact->mobile_number = $request->phone_number;
        $contact->subject = $request->subject;
        $contact->message = $request->message;
        $contact->save();

        Toastr::success('Your message send successfully!');

        return back();
    }

    public function about_us()
    {
        $about_us = BusinessSetting::where('type', 'about_us')->first();
        return view('web-views.about-us', [
            'about_us' => $about_us,
        ]);
    }

    public function consign()
    {
        $help_topics = HelpTopic::get();
        return view('web-views.consign', compact('help_topics'));
    }

    public function consignSubmit(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:32',
            'last_name' => 'required|string|max:32',
            'email' => 'required|email|max:128|regex:/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/',
            'details' => 'required|max:3000',
        ], [
            'email.regex' => 'Please provide a valid email'
        ]);

        $consign = new Consignments;
        $consign->first_name = $request->first_name;
        $consign->last_name = $request->last_name;
        $consign->email = $request->email;
        $consign->details = $request->details;
        $consign->save();

        Toastr::info('Your query has been send successfully!');
        return back();
    }

    public function termsandCondition()
    {
        $terms_and_conditions = BusinessSetting::where('type', 'terms_and_conditions')->first();
        if (!$terms_and_conditions) {
            return abort(404);
        }
//        return $terms_and_conditions;
        return view('front.refundpolicy', compact('terms_and_conditions'));
    }

    public function privacy_policy()
    {
        $privacy_policy = BusinessSetting::where('type', 'privacy_policy')->first();
        if (!$privacy_policy) {
            return abort(404);
        }
        return view('front.privacyPolicy', compact('privacy_policy'));
    }

    public function pull()
    {
        $pull = BusinessSetting::where('type', 'pull')->first();
        if (!$pull) {
            return abort(404);
        }
        return view('web-views.pull', compact('pull'));
    }

    public function shipping_and_exchange()
    {
        $shipping_and_exchange = BusinessSetting::where('type', 'shipping_and_exchange')->first();
        if (!$shipping_and_exchange) {
            return abort(404);
        }
        return view('web-views.shippingAndExchange', compact('shipping_and_exchange'));
    }

    public function faq()
    {
        $help_topics = HelpTopic::get();

        return view('front.faqs', compact('help_topics'));
    }

    //order Details

    public function orderdetails()
    {
        return view('web-views.orderdetails');
    }

    public function chat_for_product(Request $request)
    {
        return $request->all();
    }

    public function supportChat()
    {
        return view('web-views.users-profile.profile.supportTicketChat');
    }

    public function error()
    {
        return view('web-views.404-error-page');
    }

    public function requestAnItem()
    {
        $products = Product::active()->get();
        return view('web-views.request', compact('products'));
    }

    public function requestAnItemSubmit(Request $request)
    {
        $request->validate([
            'product' => 'required|numeric',
            'first_name' => 'required|string|max:32',
            'last_name' => 'required|string|max:32',
            'email' => 'required|email|max:128|regex:/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/',
            'description' => 'required|max:1000',
        ], [
            'email.regex' => 'Please provide a valid email'
        ]);

        RequestItem::create(
            [
                'product_id' => $request->product,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'description' => $request->description,
            ]
        );

        Toastr::info('Your request has been submitted successfully!');
        return back();
    }

    public function look_books()
    {
        $look_books = LookBook::where('status', 1)->get();
        return view('web-views.look-books', compact('look_books'));
    }

    public function look_book_gallery($slug)
    {
        $look_book = LookBook::with(['products', 'gallery'])->where('slug', $slug)->first();

        if ($look_book) {
            return view('web-views.look_book_gallery', compact('look_book'));
        }

        return abort(404);
    }

    public function how_we_authenticate()
    {
        return view('web-views.how-we-authenticate');
    }

    public function newsletter(Request $request)
    {
        try {

            $validator = Validator::make($request->all(),[
                'email' => 'required|email|max:128|regex:/^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/',
            ], [
                'email.regex' => 'Please provide a valid email'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }

            DB::beginTransaction();

            $check = Newsletter::where('email',$request->input('email'))->first();

            if(!empty($check)){
                Toastr::info('Already Join Newsletter!!');
                return redirect()->back();
            }

            Newsletter::create([
                'email' => $request->input('email')
            ]);

            DB::commit();

            Toastr::success('Join Newsletter Successfully!!');

            return redirect()->back();
        }catch (\Exception $e){
            DB::rollBack();
            Toastr::warning($e->getMessage());
            return redirect()->back();
        }

    }
}
