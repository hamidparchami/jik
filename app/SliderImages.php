<?php

namespace App;

use App\Lib\SetActionLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SliderImages extends Model
{
    use SoftDeletes;
    use SetActionLog;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'image', 'link', 'is_active', 'order',
    ];

    /**
     * remove domain and protocol from image address
     * @param $value
     * @return mixed
     */
    public function getImageAttribute($value)
    {
        return str_replace(url('/'), '', $value);
    }
}
