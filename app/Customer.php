<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id', 'phone_number', 'first_name', 'last_name', 'username', 'chat_id', 'is_active',
    ];

    public function categories()
    {
        return $this->belongsToMany('App\CustomerCategory', 'customer_categories', 'customer_id', 'category_id');
    }
}
