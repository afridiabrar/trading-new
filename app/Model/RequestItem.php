<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'first_name',
        'last_name',
        'email',
        'description'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
