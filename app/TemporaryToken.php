<?php

namespace App;


use Jenssegers\Mongodb\Eloquent\Model;

class TemporaryToken extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'temporary_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token', 'is_valid', 'viewed_contents_count'
    ];
}
