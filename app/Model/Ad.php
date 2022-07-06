<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $guarded = [];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return asset('storage/app/public/ads/'.$this->image);
    }


}
