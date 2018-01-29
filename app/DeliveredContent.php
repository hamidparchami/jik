<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveredContent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'content', 'guid', 'status',
    ];
}
