<?php

namespace App\Model;

use App\Model\Order;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $casts = [
        'product_id' => 'integer',
        'order_id' => 'integer',
        'price' => 'float',
        'discount' => 'float',
        'qty' => 'integer',
        'tax' => 'float',
        'shipping_method_id' => 'integer',
        'seller_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id')->where('status', 1);
    }

    public function active_product()
    {
        return $this->belongsTo(Product::class)->where('status', 1);
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }

    public function shipping()
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping_method_id');
    }

    public function address()
    {
        return $this->belongsTo(ShippingAddress::class, 'shipping_address');
    }
}
