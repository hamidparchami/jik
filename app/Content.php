<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Morilog\Jalali\jDateTime;

class Content extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'text', 'photo_url', 'video_url', 'score', 'publish_time', 'type', 'order', 'is_active'
    ];

    /** convert send_time to Jalali
     * @param $value
     * @return mixed
     */
    public function getSendTimeAttribute($value)
    {
        if (!is_null($value) && $value != '') {
            $send_time_attr_time_part = explode(' ', $value);
            return jDateTime::strftime('Y/m/d', strtotime($value)) .' '. $send_time_attr_time_part[1];
        }
    }

    /** convert send_time to Gregorian
     * @param $value
     */
    public function setSendTimeAttribute($value)
    {
        if (!is_null($value) && $value != '') {
            $send_time_attr_date_part = explode('/', $value);
            $send_time_attr_time_part = explode(' ', $value);
            $this->attributes['send_time'] = implode('-', jDateTime::toGregorian($send_time_attr_date_part[0], $send_time_attr_date_part[1], $send_time_attr_date_part[2])) . ' ' . $send_time_attr_time_part[1];
        } else if ($value == '') {
            $this->attributes['send_time'] = null;
        }
    }

    public function setScoreAttribute($value)
    {
        $this->attributes['score'] = ($value == '') ? null : $value;
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = ($value == '') ? null : $value;
    }

    public function setPublishTimeAttribute($value)
    {
        $this->attributes['publish_time'] = ($value == '') ? null : $value;
    }

}
