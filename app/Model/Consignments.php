<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Consignments extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'details'
    ];
}
