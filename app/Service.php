<?php

namespace App;

use App\Lib\SetActionLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Morilog\Jalali\jDateTime;

class Service extends Model
{
    use SoftDeletes;
    use SetActionLog;

    protected $hidden = array('pivot');

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'catalog_id', 'name', 'cover_image', 'icon', 'welcome_message', 'short_description', 'price_description', 'manual_register_description', 'increase_points_description', 'disable_service_description', 'date_start', 'date_end', 'is_active', 'display_awards_date_start', 'display_awards_date_end', 'description', 'sample_text_content',
    ];

    /** convert date_start to Jalali
     * @param $value
     * @return mixed
     */
    public function getDateStartAttribute($value)
    {
        return jDateTime::strftime('Y/m/d', strtotime($value));
    }

    /** convert date_start to Gregorian
     * @param $value
     */
    public function setDateStartAttribute($value)
    {
        $date_start_arr = explode('/', $value);
        $this->attributes['date_start'] = implode('-', jDateTime::toGregorian($date_start_arr[0], $date_start_arr[1], $date_start_arr[2]));
    }

    /** convert date_end to Jalali
     * @param $value
     * @return mixed
     */
    public function getDateEndAttribute($value)
    {
        return jDateTime::strftime('Y/m/d', strtotime($value));
    }

    /** convert date_end to Gregorian
     * @param $value
     */
    public function setDateEndAttribute($value)
    {
        $date_start_arr = explode('/', $value);
        $this->attributes['date_end'] = implode('-', jDateTime::toGregorian($date_start_arr[0], $date_start_arr[1], $date_start_arr[2]));
    }

    /** convert display_awards_date_start to Jalali
     * @param $value
     * @return mixed
     */
    public function getDisplayAwardsDateStartAttribute($value)
    {
        return jDateTime::strftime('Y/m/d', strtotime($value));
    }

    /** convert display_awards_date_start to Gregorian
     * @param $value
     */
    public function setDisplayAwardsDateStartAttribute($value)
    {
        $date_start_arr = explode('/', $value);
        $this->attributes['display_awards_date_start'] = implode('-', jDateTime::toGregorian($date_start_arr[0], $date_start_arr[1], $date_start_arr[2]));
    }

    /** convert display_awards_date_end to Jalali
     * @param $value
     * @return mixed
     */
    public function getDisplayAwardsDateEndAttribute($value)
    {
        return jDateTime::strftime('Y/m/d', strtotime($value));
    }

    /** convert display_awards_date_end to Gregorian
     * @param $value
     */
    public function setDisplayAwardsDateEndAttribute($value)
    {
        $date_start_arr = explode('/', $value);
        $this->attributes['display_awards_date_end'] = implode('-', jDateTime::toGregorian($date_start_arr[0], $date_start_arr[1], $date_start_arr[2]));
    }

    /**
     * remove domain and protocol from image address
     * @param $value
     * @return mixed
     */
    public function getCoverImageAttribute($value)
    {
        return str_replace(url('/'), '', $value);
    }

    /**
     * remove domain and protocol from image address
     * @param $value
     * @return mixed
     */
    public function getIconAttribute($value)
    {
        return str_replace(url('/'), '', $value);
    }

    public function catalog()
    {
        return $this->belongsTo('App\Catalog');
    }

    public function awards()
    {
        return $this->hasMany('App\Award');
    }
}
