<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryVisitLog extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'customer_id',
    ];
}
