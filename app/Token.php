<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Token extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'tokens';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'account_id', 'correlator', 'token', 'is_valid',
    ];
}
