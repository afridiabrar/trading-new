<?php

namespace App;

use App\Model\Order;
use App\Model\Wishlist;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'f_name', 'l_name', 'name', 'email', 'password', 'phone', 'image','account_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['full_name','role','profile_url'];

    public function getFullNameAttribute()
    {
        return $this->f_name . " " . $this->l_name;
    }

    public function getRoleAttribute()
    {
        return ($this->account_type == 1)? 'Trader' : 'Customer' ;
    }

    public function wish_list()
    {
        return $this->hasMany(Wishlist::class, 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function shipping()
    {
        return $this->belongsTo(ShippingAddress::class, 'shipping_address');
    }

    public function getProfileUrlAttribute()
    {
        if ($this->image) {
            return url('storage/app/public/profile/'.$this->image);
        } else {
            return url('/storage/profile/no-image-found.webp');
        }
    }





}
