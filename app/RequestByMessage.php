<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestByMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id','customer_id', 'phone_number', 'received_content',
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
