<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Model\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        try {
            $coupon = Coupon::where(['code' => $request['code']])->first();
            if(!empty($coupon)){

                if(date('Y-m-d',strtotime($coupon->start_date)) < date('Y-m-d')
                    || date('Y-m-d',strtotime($coupon->expire_date)) > date('Y-m-d')
                ){
//                    return $this->respond([],[],404,'Success coupon!');
                    return $this->respond(['coupon'=>$coupon],[],200,'data retrieved!');

                }


                return $this->respond(['coupon'=>$coupon],[],200,'data retrieved!');
            }
            return $this->respond([],[],404,'coupon not found!');
        } catch (\Exception $e) {
            return $this->respond([],[],500,$e->getMessage());
        }
    }
}
