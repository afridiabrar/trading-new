<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Model\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function get_banners(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'banner_type' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        try {
            if ($request['banner_type'] == 'all') {
                $banners = Banner::where(['published' => 1])->get();
            } elseif ($request['banner_type'] == 'Main Banner') {
                $banners = Banner::where(['published' => 1, 'banner_type' => 'main_banner'])->get();
            } elseif ($request['banner_type'] == 'Hot Deals') {
                $banners = Banner::where(['published' => 1, 'banner_type' => 'hot_deals'])->get();
            } elseif ($request['banner_type'] == 'Product Page') {
                $banners = Banner::where(['published' => 1, 'banner_type' => 'product_page'])->get();
            } elseif ($request['banner_type'] == 'Home Page') {
                $banners = Banner::where(['published' => 1, 'banner_type' => 'home_page'])->get();
            }elseif ($request['banner_type'] == 'Trader') {
                $banners = Banner::where(['published' => 1, 'banner_type' => 'trader'])->get();
            }else {
                $banners = Banner::where(['published' => 1, 'banner_type' => 'footer_banner'])->get();
            }
        } catch (\Exception $e) {

        }

        return response()->json($banners, 200);
    }
}
