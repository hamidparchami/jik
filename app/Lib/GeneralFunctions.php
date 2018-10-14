<?php
/**
 * Created by PhpStorm.
 * User: hamid
 * Date: 1/14/17
 * Time: 11:13 AM
 */

namespace App\Lib;

class GeneralFunctions
{
    //arrays of persian and latin numbers for convert
    const PERSIAN_NUMBERS   = array('۰','۱','۲','۳','۴','٤','۵','٥','۶','٦','۷','۸','۹');
    const LATIN_NUMBERS     = array('0','1','2','3','4','4','5','5','6','6','7','8','9');

    /**
     * @param $width
     * @param $height
     * @return mixed
     */
    private static function gcd($width, $height)
    {
        return ($width % $height) ? self::gcd($height, $width % $height) : $height;
    }

    /**
     * @param $width
     * @param $height
     * @return string
     */
    public static function getAspectRatio($width, $height)
    {
        $gcd = self::gcd($width, $height);
        return ($width/$gcd).':'.($height/$gcd);
    }

    /**
     * validate image dimensions
     * @param $image_dimensions
     * @param $allowed_dimensions
     * @param $allowed_aspect
     * @return bool
     */
    public static function checkDimensions($image_dimensions, $allowed_dimensions, $allowed_aspect=null)
    {
        //check aspect ratio
        if (!is_null($allowed_aspect) && self::getAspectRatio($image_dimensions[0], $image_dimensions[1]) != $allowed_aspect) {
            return false;
        }

        //check allowed sizes
        if (array_key_exists('width', $allowed_dimensions) || array_key_exists('height', $allowed_dimensions)) {
            if ($image_dimensions[0] != $allowed_dimensions['width'] || $image_dimensions[1] != $allowed_dimensions['height']) {
                return false;
            }
        } else {
            if ((isset($allowed_dimensions['min_width'])  && $image_dimensions[0] < $allowed_dimensions['min_width'])  ||
                (isset($allowed_dimensions['min_height']) && $image_dimensions[1] < $allowed_dimensions['min_height']) ||
                (isset($allowed_dimensions['max_width'])  && $image_dimensions[0] > $allowed_dimensions['max_width'])  ||
                (isset($allowed_dimensions['max_height']) && $image_dimensions[1] > $allowed_dimensions['max_height'])) {
                return false;
            }
        }
        return true;
    }

    /**
     * generate GUID
     * @return string
     */
    public static function GUID()
    {
        if (function_exists('com_create_guid') === true)
        {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    /**
     * check if value is set and is not null
     * @param $value
     * @return bool
     */
    public static function isSetAndIsNotNull($value)
    {
        if(isset($value) && !is_null($value) && $value != '') {
            return true;
        }
        return false;
    }

    public static function convertToPersianNumbers($value)
    {
        return str_replace(self::LATIN_NUMBERS, self::PERSIAN_NUMBERS, $value);
    }

    public static function convertToLatinNumbers($value)
    {
        return str_replace(self::PERSIAN_NUMBERS, self::LATIN_NUMBERS, $value);
    }

    /**
     * add leading zero to hour and minute in given time
     * @param $time
     * @return string
     */
    public static function addLeadingZeroToTime($time)
    {
        $send_time_attr_date_part = explode(' ', $time);
        $send_time_attr_time_part = explode(':', $send_time_attr_date_part[1]);

        $send_time_attr_time_part[0] = (strlen($send_time_attr_time_part[0]) == 1 && $send_time_attr_time_part[0] < 10) ? '0'.$send_time_attr_time_part[0] : $send_time_attr_time_part[0];
        $send_time_attr_time_part[1] = (strlen($send_time_attr_time_part[1]) == 1 && $send_time_attr_time_part[1] < 10) ? '0'.$send_time_attr_time_part[1] : $send_time_attr_time_part[1];

        return $send_time_attr_date_part[0] . ' ' . $send_time_attr_time_part[0] . ':' . $send_time_attr_time_part[1];
    }
}