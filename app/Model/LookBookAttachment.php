<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LookBookAttachment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'look_book_id',
        'image'
    ];
}
