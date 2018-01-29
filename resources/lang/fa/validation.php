<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'between'              => [
        'numeric' => 'مقدار فیلد :attribute می بایست بین :min تا :max باشد.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'مقدار فیلد :attribute با فیلد تاییدیه برابر نیست.',
    'date'                 => 'ساختار تاریخ برای فیلد :attribute صحیح نمی باشد.',
    'date_format'          => 'فرمت تاریخ :attribute با فرمت صحیح :format مطابقت ندارد.',
    'different'            => 'مقدار فیلد :attribute و :other نمی توانند یکسان باشند.',
    'digits'               => ':digits رقم برای فیلد :attribute وارد کنید.',
    'digits_between'       => 'مقدار فیلد :attribute می بایست بین :min تا :max عدد باشد.',
    'dimensions'           => 'ابعاد :attribute صحیح نیست.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'The :attribute must be a valid email address.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field is required.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'مقدار فیلد :attribute نمی تواند از :max بیشتر باشد.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'The :attribute may not be greater than :max characters.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'مقدار فیلد :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'مقدار فیلد :attribute می بایست حداقل :min کاراکتر باشد.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'مقدار وارد شده برای فیلد :attribute صحیح نمی باشد.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'مقدار وارد شده برای فیلد :attribute صحیح نمی باشد.',
    'required'             => 'فیلد :attribute اجباری می باشد.',
    'required_if'          => 'فیلد :attribute در صورتیکه مقدار فیلد :other  :value باشد اجباری است.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'مقدار فیلد :attribute و :other می بایست یکسان باشند.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'The :attribute must be :size characters.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => 'مقدار فیلد :attribute قبلا در دیتابیس ثبت شده است.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'نام',
        'title' => 'عنوان',
        'image' => 'تصویر',
        'description' => 'توضیح',
        'count' => 'تعداد',
        'phone_number' => 'شماره تلفن',
        'verification_code' => 'کد تایید',
        'display_date_start' => 'تاریخ شروع نمایش',
        'display_date_end' => 'تاریخ پایان نمایش',
        'order' => 'ترتیب',
        'minimum_point' => 'حداقل امتیاز',
        'date_start' => 'تاریخ شروع',
        'date_end' => 'تاریخ پایان',
        'link' => 'لینک',
        'text' => 'متن',
        'video' => 'ویدیو',
        'firstname' => 'نام',
        'lastname' => 'نام خانوادگی',
        'price' => 'قیمت',
        'short_content' => 'متن کوتاه',
        'content' => 'محتوا',
        'current_password' => 'رمز عبور فعلی',
        'new_password' => 'رمز عبور جدید',
        'category_id' => 'دسته',
        'point' => 'امتیاز',
        'success_message' => 'پیام موفقیت',
        'score' => 'امتیاز',
        'send_time' => 'زمان ارسال',
        'number' => 'سر‌شماره',
        'value' => 'مقدار',
        'service_id' => 'سرویس',
        'operator' => 'اپراتور',
        'send_time_from' => 'از تاریخ',
        'send_time_to' => 'تا تاریخ',
        'type' => 'نوع',
        'send_type' => 'روش ارسال',
        'photo' => 'عکس',
        'audio' => 'صوت',
        'photo_url' => 'آدرس فایل عکس',
        'video_url' => 'آدرس فایل ویدئو',
        'audio_url' => 'آدرس فایل صوتی',
    ],

];
