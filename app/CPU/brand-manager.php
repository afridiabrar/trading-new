<?php

namespace App\CPU;

use App\Model\Brand;
use App\Model\Product;

class BrandManager
{
    public static function get_brands()
    {
        return Brand::withCount('brandProducts')->latest()->get();

    }

    public static function get_products($brand_id,$limit = 12, $offset = 0)
    {
        $paginator = Product::active()->with(['rating'])->where('brand_id',$brand_id)->
        latest()->paginate($limit, ['*'], 'page', $offset);
        /*$paginator->count();*/
        return [
            'products' => $paginator
        ];
//        return Helpers::product_data_formatting(Product::where(['brand_id' => $brand_id])->get(), true);
    }
}
