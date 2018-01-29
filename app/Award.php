<?php

namespace App;

use App\Lib\GeneralFunctions;
use App\Lib\SetActionLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Morilog\Jalali\jDateTime;

class Award extends Model
{
    use SoftDeletes;
    use SetActionLog;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_id', 'award_type_id', 'title', 'description', 'image', 'order', 'count', 'display_date_start', 'display_date_end', 'is_important', 'minimum_point', 'price',
    ];

    public function filterPhoneNumber($phone_number)
    {
        return str_replace(substr($phone_number, 4, 4), '****', $phone_number);
    }

    /** Get display_date_start
     * @param $value
     * @return mixed
     */
    public function getDisplayDateStartAttribute($value)
    {
        return jDateTime::strftime('Y/m/d', strtotime($value));
    }

    /** Set display_date_start
     * @param $value
     */
    public function setDisplayDateStartAttribute($value)
    {
        $date_start_arr = explode('/', $value);
        $this->attributes['display_date_start'] = implode('-', jDateTime::toGregorian($date_start_arr[0], $date_start_arr[1], $date_start_arr[2]));
    }

    /** Get display_date_end
     * @param $value
     * @return mixed
     */
    public function getDisplayDateEndAttribute($value)
    {
        return jDateTime::strftime('Y/m/d', strtotime($value));
    }

    /** Set display_date_end
     * @param $value
     */
    public function setDisplayDateEndAttribute($value)
    {
        $date_start_arr = explode('/', $value);
        $this->attributes['display_date_end'] = implode('-', jDateTime::toGregorian($date_start_arr[0], $date_start_arr[1], $date_start_arr[2]));
    }

    /**
     * check if order is set and is not null
     * @param $value
     */
    public function setOrderAttribute($value)
    {
        $this->attributes['order'] = (GeneralFunctions::isSetAndIsNotNull($value)) ? $value : 0;
    }

    /**
     * check if price is set and is not null
     * @param $value
     */
    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = (GeneralFunctions::isSetAndIsNotNull($value)) ? $value : 0;
    }

    /**
     * remove domain and protocol from image address
     * @param $value
     * @return mixed
     */
    public function getImageAttribute($value)
    {
        return str_replace(url('/'), '', $value);
    }

    public function type()
    {
        return $this->belongsTo('App\AwardType', 'award_type_id');
    }

    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function winners()
    {
        return $this->hasMany('App\AwardWinner');
    }

    public function staticPage()
    {
        return $this->hasOne('App\AwardStaticPage');
    }
}
