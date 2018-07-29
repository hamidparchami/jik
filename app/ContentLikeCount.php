<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class ContentLikeCount extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'content_like_counts';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content_id', 'count'
    ];
}
