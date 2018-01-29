<?php

namespace App;

use App\Lib\GeneralFunctions;
use App\Lib\SetActionLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Url extends Model
{
    use SoftDeletes;
//    use SetActionLog;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id','url','title','order',
    ];

    /**
     * check if order is set and is not null
     * @param $value
     */
    public function setOrderAttribute($value)
    {
        $this->attributes['order'] = (GeneralFunctions::isSetAndIsNotNull($value)) ? $value : 0;
    }

    public function children()
    {
        return $this->hasMany('App\Url', 'parent_id')->orderBy('order', 'desc');
    }
}
