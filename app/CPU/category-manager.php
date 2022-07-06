<?php

namespace App\CPU;

use App\Model\Category;
use App\Model\Product;

class CategoryManager
{
    public static function parents()
    {
        $x = Category::with(['childes.childes'])->where('position', 0)->get();
        return $x;
    }

    //    public function subCategory($)
    //    {
    //
    //    }

    public static function child($parent_id)
    {
        $x = Category::where(['parent_id' => $parent_id])->get();
        return $x;
    }

    public static function countProducts($category_id, $sub_category_id)
    {
        $products = Product::active()->get();
        $count = 0;
        $product_ids = [];
        foreach ($products as $product) {
            foreach (json_decode($product['category_ids'], true) as $category) {
                if ($category['id'] == $sub_category_id && $category['position'] == "2") {
                    $count += 1;
                    //                    array_push($product_ids, $product['id']);
                }
            }
        }
        return $count;
        //        return Product::whereIn('id', $product_ids)->count();
    }

    public static function products($category_id, $limit = 10, $offset = 1, $status = null)
    {
        $products = Product::active()->get();

        $product_ids = [];


        foreach ($products as $product) {
            $categories = json_decode($product['category_ids'], true);

            if (count(json_decode($product['category_ids'], true)) > 0) {
                //                var_dump($categories['id']);
                //                foreach ($categories as $category) {
                // return $category_id;
                if (in_array($category_id, $categories)) {
                    $product_ids[] = $product->id;

                    //                    array_push($product_ids, $product->id);
                }
                //Start ff
                // else {
                //     $product_ids[] = $product->id;
                //     return Product::with(['rating'])
                //         ->whereIn('id', $product_ids)
                //         ->paginate($limit, ['*'], 'page', $offset);
                // }
                //End
                // return $product_ids;
                //                }
                //                echo  "</br>";
            }
        }
//        return $product_ids;
        //        return "dsd";

        if ($status === "high_to_low") {
            return Product::orderBy('unit_price', 'desc')
                ->with(['rating'])
                ->whereIn('id', $product_ids)
                ->paginate($limit, ['*'], 'page', $offset);
        }

        if ($status === "low_to_high") {
            return Product::orderBy('unit_price', 'asc')
                ->with(['rating'])
                ->whereIn('id', $product_ids)
                ->paginate($limit, ['*'], 'page', $offset);
        }


        return Product::with(['rating'])
            ->whereIn('id', $product_ids)
            ->paginate($limit, ['*'], 'page', $offset);
    }

    public static function hotProducts($category_id, $limit = 10, $offset = 1, $status = null)
    {
        $products = Product::active()->get();
        $product_ids = [];
        foreach ($products as $product) {
            if (count(json_decode($product['category_ids'], true)) > 0) {
                foreach (json_decode($product['category_ids'], true) as $category) {
                    if ($category['id'] == $category_id) {
                        $product_ids[] = $product['id'];
                        //                    array_push($product_ids, $product->id);
                    }
                }
            }
        }

        if ($status === "high_to_low") {
            return Product::orderBy('unit_price', 'desc')
                ->with(['rating'])
                ->whereIn('id', $product_ids)
                ->where('featured', '1')
                ->paginate($limit, ['*'], 'page', $offset);
        }

        if ($status === "low_to_high") {
            return Product::orderBy('unit_price', 'asc')
                ->with(['rating'])
                ->whereIn('id', $product_ids)
                ->where('featured', '1')
                ->paginate($limit, ['*'], 'page', $offset);
        }

        return Product::with(['rating'])
            ->whereIn('id', $product_ids)
            ->where('featured', '1')
            ->paginate($limit, ['*'], 'page', $offset);
    }

    public static function tradingProducts($category_id, $status = null)
    {
        $products = Product::active()->get();
        $product_ids = [];
        foreach ($products as $product) {
            if (count(json_decode($product['category_ids'], true)) > 0) {
                foreach (json_decode($product['category_ids'], true) as $category) {
                    if ($category['id'] == $category_id) {
                        $product_ids[] = $product['id'];
                        //                    array_push($product_ids, $product->id);
                    }
                }
            }
        }

        if ($status === "high_to_low") {
            return Product::orderBy('unit_price', 'desc')
                ->with(['rating'])
                ->whereIn('id', $product_ids)
                ->where('is_trade', '1')
                ->get();
        }

        if ($status === "low_to_high") {
            return Product::orderBy('unit_price', 'asc')
                ->with(['rating'])
                ->whereIn('id', $product_ids)
                ->where('is_trade', '1')
                ->get();
        }

        return Product::with(['rating'])
            ->whereIn('id', $product_ids)
            ->where('is_trade', '1')
            ->get();
    }
}
