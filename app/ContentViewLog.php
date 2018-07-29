<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class ContentViewLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'content_view_logs';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content_id', 'customer_id', 'temporary_token'
    ];
}
