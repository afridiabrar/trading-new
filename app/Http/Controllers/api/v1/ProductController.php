<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\CategoryManager;
use App\CPU\Helpers;
use App\CPU\ProductManager;
use App\Http\Controllers\Controller;
use App\Model\OrderDetail;
use App\Model\Product;
use App\Model\Review;
use App\Model\ShippingMethod;
use App\Model\Wishlist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function get_latest_products(Request $request)
    {
        try {

            if ($request->category_id) {
                if ($request->status === "high_to_low") {
                    $products = CategoryManager::products($request->category_id, $limit = 10, $offset = 1, $request->status);
                    return $this->respond($products, [], 200);
                }
                if ($request->status === "low_to_high") {
                    $products = CategoryManager::products($request->category_id, $limit = 10, $offset = 1, $request->status);
                    return $this->respond($products, [], 200);
                }
                if ($request->status === 'undefined') {
                    //  return  var_dump($request->category_id);
                    $users = Product::whereJsonContains('category_ids->id', (int)$request->category_id)->get();
                    return $this->respond($users, [], 200);
                    // $products = CategoryManager::products($request->category_id, $limit = 10, $offset = 1, $request->status);
                    // return $this->respond($products, [], 200);
                }
                // return $id;

                $products = CategoryManager::products($request->category_id);
            } elseif ($request->start) {
                    $products = ProductManager::get_by_price_products(
                        $request['start'],
                        $request['end'],
                        '',
                        $request['limit'],
                        $request['offset']);
            } else {
                if($request->status === "high_to_low"){
                    $products = ProductManager::get_latest_products($request['limit'], $request['offset'],$request->status);
                    return $this->respond($products,[],200);
                }
                if($request->status === "low_to_high"){
                    $products = ProductManager::get_latest_products($request['limit'], $request['offset'],$request->status);
                    return $this->respond($products,[],200);
                }

                $products = ProductManager::get_latest_products($request['limit'], $request['offset']);
            }
            return $this->respond($products,[],200);

        }catch (\Exception $e){

            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function get_trading_products(Request $request)
    {
        try {

            if($request->status === "high_to_low"){
                $products = ProductManager::get_trading_products($request['limit'], $request['offset'],$request->status);
                return $this->respond($products,[],200);
            }
            if($request->status === "low_to_high"){
                $products = ProductManager::get_trading_products($request['limit'], $request['offset'],$request->status);
                return $this->respond($products,[],200);
            }

            $products = ProductManager::get_trading_products($request['limit'], $request['offset']);
//            $products['products'] = Helpers::product_data_formatting($products['products'], true);
            return $this->respond($products,[],200);

        }catch (\Exception $e){

            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function get_hot_deals(Request $request)
    {
        try {

            $products = ProductManager::get_hot_deals_products($request['limit'], $request['offset']);
//            $products['products'] = Helpers::product_data_formatting($products['products'], true);
            return $this->respond($products,[],200);

        }catch (\Exception $e){

            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function get_searched_products(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->respond([],Helpers::error_processor($validator), 403);
            }
            $products = ProductManager::search_products($request['name'], $request['limit'], $request['offset']);
//          $products['products'] = Helpers::product_data_formatting($products['products'], true);
            return $this->respond($products,[], 200);
        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function searchByPriceRange(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'start' => 'required|numeric',
                'end' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return $this->respond([],Helpers::error_processor($validator), 403);
            }
            if($request->category){
                $products = ProductManager::get_by_price_products(
                    $request['start'],
                    $request['end'],
                    $request->category,
                    $request['limit'],
                    $request['offset']
                );
                return $this->respond($products,[], 200,'success');
            }
            $products = ProductManager::get_by_price_products($request['start'],$request['end'],null, $request['limit'], $request['offset']);
            return $this->respond($products,[], 200,'success');
        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function get_product($id)
    {
        try {

            $product = Product::find($id);

            if(empty($product)) return $this->respond([],[], 404,'product not found');

//            $product = Helpers::product_data_formatting($product, false);

            return $this->respond(['product'=>$product],[], 200);
        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function get_related_products($id)
    {
        try {
            if (Product::find($id)) {

                $products = ProductManager::get_related_products($id);
                $products = Helpers::product_data_formatting($products, true);

                return $this->respond($products,[],200);
            }
//            return response()->json([
//                'errors' => ['code' => 'product-001', 'message' => 'Product not found!']
//            ], 404);
            return $this->respond([],[],404,'Product not found!');

        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function get_product_reviews($id)
    {
        try {
            $reviews = Review::with(['customer'])->where(['product_id' => $id])->paginate(6);
            $storage = [];
//            return $reviews;
//            foreach ($reviews as $item) {
//                $item['attachment'] = json_decode($item['attachment']);
//                array_push($storage, $item);
//            }
            return $this->respond($reviews,[],200);
        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function get_product_rating($id)
    {
        try {
            $product = Product::find($id);
            $overallRating = \App\CPU\ProductManager::get_overall_rating($product->reviews);
            $rating = (!empty($overallRating))? floatval($overallRating[0]) : 0;
            return $this->respond(['rating' => $rating ],[],200);
//            return response()->json(floatval($overallRating[0]), 200);
        } catch (\Exception $e) {
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function counter($product_id)
    {
        try {
            $countOrder = OrderDetail::where('product_id', $product_id)->count();
            $countWishlist = Wishlist::where('product_id', $product_id)->count();
            return response()->json(['order_count' => $countOrder, 'wishlist_count' => $countWishlist], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function social_share_link($product_id)
    {
        $product = Product::find($product_id);
        $link = route('product', $product->slug);
        try {

            return response()->json($link, 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => $e], 403);
        }
    }

    public function submit_product_review(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'product_id' => 'required|integer',
                'comment' => 'required|string',
                'rating' => 'required|numeric|between:1,5',
            ]);

            if ($validator->fails()) {
                return $this->respond([],Helpers::error_processor($validator),403);
                return response()->json(['errors' => Helpers::error_processor($validator)], 403);
            }

            $image_array = [];
            if (!empty($request->file('fileUpload'))) {
                foreach ($request->file('fileUpload') as $image) {
                    if ($image != null) {
                        if (!Storage::disk('public')->exists('review')) {
                            Storage::disk('public')->makeDirectory('review');
                        }
                        array_push($image_array, Storage::disk('public')->put('review', $image));
                    }
                }
            }

            $review = new Review;
            $review->customer_id = $request->user()->id;
            $review->product_id = $request->product_id;
            $review->comment = $request->comment;
            $review->rating = $request->rating;
            $review->attachment = json_encode($image_array);
            $review->save();

//            $singleReview = Review::with(['customer'])->where(['id' => $review->id])->first();
//            $singleReview['attachment'] = json_decode($singleReview['attachment']);

            $reviews = Review::with(['customer'])->where(['product_id' => $request->product_id])->get();
            $storage = [];
            foreach ($reviews as $item) {
                $item['attachment'] = json_decode($item['attachment']);
                array_push($storage, $item);
            }
//            return $this->respond($storage,[],200);
            return $this->respond($reviews,[],200,'successfully review submitted!');
//            return response()->json(['message' => 'successfully review submitted!'], 200);
        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function get_shipping_methods(Request $request){
        $methods = ShippingMethod::where(['status' => 1])->get();
        return response()->json($methods, 200);
    }
}
