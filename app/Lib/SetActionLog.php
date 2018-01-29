<?php
/**
 * Created by PhpStorm.
 * User: Hamid Parchami <hamidparchami@gmail.com>
 * Date: 3/26/17
 * Time: 3:36 PM
 */

namespace App\Lib;


use App\ActionLog;
use Illuminate\Support\Facades\Auth;

trait SetActionLog
{
    public static $changed_attributes = [];
    public static $entity_types       = [
                                        'App\Award'                => 'award',
                                        'App\AwardStaticPage'      => 'award_static_page',
                                        'App\AwardStaticPageImage' => 'award_static_page_image',
                                        'App\AwardType'            => 'award_type',
                                        'App\AwardWinner'          => 'award_winner',
                                        'App\Catalog'              => 'catalog',
                                        'App\Event'                => 'event',
                                        'App\Method'               => 'method',
                                        'App\Role'                 => 'role',
                                        'App\Service'              => 'service',
                                        'App\ServiceTextSample'    => 'service_text_sample',
                                        'App\SliderImages'         => 'slider_images',
                                        'App\Url'                  => 'url',
                                        'App\User'                 => 'user',
                                        ];

    /**
     * @param $attribute
     * @param $value
     */
    public static function setChanged($attribute, $value)
    {
        self::$changed_attributes[$attribute] = $value;
    }

    /**
     * @return array
     */
    public static function getChanged()
    {
        return self::$changed_attributes;
    }

    /**
     * @param $model
     */
    public static function determineChanges($model)
    {
        if ($model->isDirty()) {
            foreach ($model->getDirty() as $attribute => $value) {
                self::setChanged($attribute, $model->getOriginal($attribute));
            }
        }
    }

    /**
     * @return string
     */
    public static function getClientIP()
    {
        $ip = getenv('HTTP_CLIENT_IP')?:
                getenv('HTTP_X_FORWARDED_FOR')?:
                    getenv('HTTP_X_FORWARDED')?:
                        getenv('HTTP_FORWARDED_FOR')?:
                            getenv('HTTP_FORWARDED')?:
                                getenv('REMOTE_ADDR');
        return $ip;
    }
    /**
     * @param $data
     * @return string
     */
    public static function convertToJson($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * set action log on model's events (update, delete, etc)
     */
    public static function boot()
    {
        parent::boot();

        static::updating(function($model)
        {
            self::determineChanges($model);
            ActionLog::create(['entity_id'   => $model->id,
                               'user_id'     => Auth::id(),
                               'entity_type' => self::$entity_types[get_class($model)],
                               'action'      => 'update',
                               'change'      => self::convertToJson(self::getChanged()),
                               'user_ip'     => self::getClientIP()
            ]);
        });

        static::deleting(function($model)
        {
            ActionLog::create(['entity_id'   => $model->id,
                               'user_id'     => Auth::id(),
                               'entity_type' => self::$entity_types[get_class($model)],
                               'action'      => 'delete',
                               'change'      => $model->toJson(JSON_UNESCAPED_UNICODE),
                               'user_ip'     => self::getClientIP()
            ]);
        });
    }
}