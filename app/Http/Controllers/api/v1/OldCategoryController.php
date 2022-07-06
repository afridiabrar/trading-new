<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\CategoryManager;
use App\CPU\Helpers;
use App\CPU\ProductManager;
use App\Http\Controllers\Controller;
use App\Model\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function get_categories()
    {
        try {
            $categories = Category::with(['childes.childes'])->where(['position' => 0])->get();
            return $this->respond($categories,[],200);
        } catch (\Exception $e) {
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function get_products(Request $request,$id)
    {
        try {

            if($request->status === "high_to_low"){
                $products = CategoryManager::products($id,$limit = 10, $offset = 1,$request->status);
                return $this->respond($products,[],200);
            }
            if($request->status === "low_to_high"){
                $products = CategoryManager::products($id,$limit = 10, $offset = 1,$request->status);
                return $this->respond($products,[],200);
            }
                // return $id;

            $products = CategoryManager::products($id);
            return $products;

            return $this->respond($products,[],200);

        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function get_hot_deals_products(Request $request , $id)
    {
        try {

            if($request->status === "high_to_low"){
                $products = CategoryManager::hotProducts($id,$limit = 10, $offset = 1,$request->status);
                return $this->respond($products,[],200);
            }
            if($request->status === "low_to_high"){
                $products = CategoryManager::hotProducts($id,$limit = 10, $offset = 1,$request->status);
                return $this->respond($products,[],200);
            }

            $products = CategoryManager::hotProducts($id);
            return $this->respond($products,[],200);

        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }

    public function get_trading_products(Request $request,$id)
    {
        try {

            if($request->status === "high_to_low"){
                $products = CategoryManager::tradingProducts($id,$request->status);
                return $this->respond($products,[],200);
            }
            if($request->status === "low_to_high"){
                $products = CategoryManager::tradingProducts($id,$request->status);
                return $this->respond($products,[],200);
            }

            $products = CategoryManager::tradingProducts($id);
            return $this->respond($products,[],200);

        }catch (\Exception $e){
            return $this->respond([],[],500,$e->getMessage());
        }
    }

}
