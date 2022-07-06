<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $casts = [
        'published'  => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['banner_image_url'];

    public function getBannerImageUrlAttribute()
    {
        return asset('storage/banner/'.$this->photo);
        // return asset('storage/app/public/banner/'.$this->photo);
    }

}
