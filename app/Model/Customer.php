<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticatable
{
    use Notifiable, HasApiTokens;

    public function getImageAttribute($value)
    {
        if ($value) {
            return url($value);
        } else {
            return url('/storage/app/public/profile/no-image-found.webp');
        }
    }

}
