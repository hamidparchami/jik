<?php

namespace App;

use App\Lib\SetActionLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
//    use SetActionLog;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
    public function urls()
    {
        return $this->belongsToMany('App\Url', 'role_url', 'role_id', 'url_id');
    }
}
