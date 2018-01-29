<?php

namespace App;

use App\Lib\SetActionLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catalog extends Model
{
    use SoftDeletes;
    use SetActionLog;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 'name', 'image', 'is_active', 'is_important',
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

    public function services()
    {
        return $this->hasMany('App\Service')->where('is_active', 1)->where('date_start', '<=', Carbon::today()->format('Y-m-d'))->where('date_end', '>=', Carbon::today()->format('Y-m-d'));
    }

    public function children()
    {
        return $this->hasMany('App\Catalog', 'parent_id');
    }
}
