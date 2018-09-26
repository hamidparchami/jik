<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Morilog\Jalali\jDateTime;

class Content extends Model
{
    use SoftDeletes;

    protected $appends = ['published_at', 'view_count', 'like_count'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'service_id', 'category_id', 'user_id', 'text', 'main_image', 'full_content', 'photo_url', 'video_url', 'score', 'publish_time', 'type', 'order', 'reference', 'show_instant_view', 'is_active'
    ];

    public function convertNumberToFa($value)
    {
        $persian_digits = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹');
        $english_digits = array('0','1','2','3','4','5','6','7','8','9');
        $value          = str_replace($english_digits, $persian_digits, $value);
        return $value;
    }

    /** convert created_at to Jalali and return as published_at
     * @param $value
     * @return mixed
     */
    public function getPublishedAtAttribute() {
        $value = $this->created_at;

        if (!is_null($value) && $value != '') {
            $send_time_attr_time_part = explode(' ', $value);
            return $this->convertNumberToFa(jDateTime::strftime('Y/m/d', strtotime($value)) .' '. substr($send_time_attr_time_part[1], 0, -3));
        }
    }

    /**
     * @return int
     */
    public function getViewCountAttribute() {
        $contentViewCount = ContentViewCount::where('content_id', $this->id)->first();
        if(is_null($contentViewCount)) {
            $ViewCount = rand(100, 999);
            ContentViewCount::create(['content_id' => $this->id, 'count' => $ViewCount, 'original_count' => 1]);
        } else {
            $ViewCount = $contentViewCount->count;
        }
        return $this->convertNumberToFa($ViewCount);
    }

    /**
     * @return int
     */
    public function getLikeCountAttribute() {
        $contentLikeCount = ContentLikeCount::where('content_id', $this->id)->first();
        if(is_null($contentLikeCount)) {
            $likeCount = rand(10, 99);
            ContentLikeCount::create(['content_id' => $this->id, 'count' => $likeCount, 'original_count' => 0]);
        } else {
            $likeCount = $contentLikeCount->count;
        }
        return $this->convertNumberToFa($likeCount);
    }

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

    public function getMainImageAttribute($value)
    {
        return str_replace('https://www.', 'https://', $value);
    }
    public function service()
    {
        return $this->belongsTo('App\Service');
    }

    public function category()
    {
        return $this->belongsTo('App\ContentCategory');
    }
}
