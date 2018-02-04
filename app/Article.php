<?php

namespace App;

use App\Lib\GeneralFunctions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Morilog\Jalali\jDateTime;

class Article extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'title', 'short_content', 'content', 'slug', 'image', 'order', 'meta_keywords', 'meta_description', 'robots_follow_type', 'is_active', 'is_important', 'can_comment', 'can_like',
    ];

    /**
     * check if order is set and is not null
     * @param $value
     */
    public function setOrderAttribute($value)
    {
        $this->attributes['order'] = (GeneralFunctions::isSetAndIsNotNull($value)) ? $value : 0;
    }

    /** convert date to jalali
     * @param $value
     * @return mixed
     */
    public function convertToJalali($value)
    {
        return $this->convertNumberToFa(jDateTime::strftime('Y/m/d', strtotime($value)));
    }

    public function convertNumberToFa($value)
    {
        $persian_digits = array('۰','۱','۲','۳','۴','۵','۶','۷','۸','۹');
        $english_digits = array('0','1','2','3','4','5','6','7','8','9');
        $value          = str_replace($english_digits, $persian_digits, $value);
        return $value;
    }
}
