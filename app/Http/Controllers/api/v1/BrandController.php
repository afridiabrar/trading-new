<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\BrandManager;
use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function get_brands()
    {
        try {
            $brands = BrandManager::get_brands();
            return $this->respond($brands,[],200,'success retrieved');
        } catch (\Exception $e) {
            return $this->respond([],[],500,$e->getMessage());
        }

    }

    public function get_products($brand_id)
    {
        try {
            $products = BrandManager::get_products($brand_id);
            return $this->respond($products,[],200,'success retrieved');
        } catch (\Exception $e) {
            return $this->respond([],[],500,$e->getMessage());
        }
    }
}
