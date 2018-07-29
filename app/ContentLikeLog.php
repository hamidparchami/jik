<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class ContentLikeLog extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'content_likes';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id', 'content_id',
    ];
}
