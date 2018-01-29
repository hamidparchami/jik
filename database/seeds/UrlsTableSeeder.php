<?php

use App\Url;
use Illuminate\Database\Seeder;

class UrlsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Dashboard
        $general = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'عمومی']);
        Url::create(['parent_id' => $general->id, 'url' => 'admin/home', 'title' => 'داشبورد']);
        //Catalog
        $catalog = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'کاتالوگ']);
        Url::create(['parent_id' => $catalog->id, 'url' => 'admin/catalog/manage/{parent_id?}', 'title' => 'مدیریت کاتالوگ‌ها']);
        Url::create(['parent_id' => $catalog->id, 'url' => 'admin/catalog/create/{parent_id?}', 'title' => 'ایجاد کاتالوگ']);
        Url::create(['parent_id' => $catalog->id, 'url' => 'admin/catalog/edit/id/{id}/{parent_id?}', 'title' => 'ویرایش کاتالوگ']);
        Url::create(['parent_id' => $catalog->id, 'url' => 'admin/catalog/delete/id/{id}/{parent_id?}', 'title' => 'حذف کاتالوگ']);
        //Event
        $event = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'رویداد']);
        Url::create(['parent_id' => $event->id, 'url' => 'admin/event/manage', 'title' => 'مدیریت رویدادها']);
        Url::create(['parent_id' => $event->id, 'url' => 'admin/event/create', 'title' => 'ایجاد رویداد']);
        Url::create(['parent_id' => $event->id, 'url' => 'admin/event/edit/id/{id}', 'title' => 'ویرایش رویداد']);
        Url::create(['parent_id' => $event->id, 'url' => 'admin/event/delete/id/{id}', 'title' => 'حذف رویداد']);
        //Service
        $service = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'سرویس']);
        Url::create(['parent_id' => $service->id, 'url' => 'admin/service/manage', 'title' => 'مدیریت سرویس‌ها']);
        Url::create(['parent_id' => $service->id, 'url' => 'admin/service/create', 'title' => 'ایجاد سرویس']);
        Url::create(['parent_id' => $service->id, 'url' => 'admin/service/edit/id/{id}', 'title' => 'ویرایش سرویس']);
        Url::create(['parent_id' => $service->id, 'url' => 'admin/service/delete/id/{id}', 'title' => 'حذف سرویس']);
        //Service Awards
        $award = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'جوایز سرویس']);
        Url::create(['parent_id' => $award->id, 'url' => 'admin/service/award/service_id/{service_id}', 'title' => 'مدیریت جوایز']);
        Url::create(['parent_id' => $award->id, 'url' => 'admin/service/award/create/service_id/{service_id}', 'title' => 'ایجاد جایزه']);
        Url::create(['parent_id' => $award->id, 'url' => 'admin/service/award/edit/service_id/{service_id}/award_id/{id}', 'title' => 'ویرایش جایزه']);
        Url::create(['parent_id' => $award->id, 'url' => 'admin/service/award/delete/service_id/{service_id}/award_id/{id}', 'title' => 'حذف جایزه']);
        //Award winners
        $award_winner = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'برندگان']);
        Url::create(['parent_id' => $award_winner->id, 'url' => 'admin/service/award/winner/service_id/{service_id}/award_id/{award_id}', 'title' => 'ثبت برندگان']);
        //Service Text Sample
        $text_sample = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'نمونه محتوا']);
        Url::create(['parent_id' => $text_sample->id, 'url' => 'admin/service/text-sample/edit/service_id/{service_id}', 'title' => 'ثبت نمونه محتوا']);
        //Award Static Page
        $award_page = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'صفحه جایزه']);
        Url::create(['parent_id' => $award_page->id, 'url' => 'admin/service/award/page/service_id/{service_id}/award_id/{award_id}', 'title' => 'ثبت اطلاعات']);
        Url::create(['parent_id' => $award_page->id, 'url' => 'admin/service/award/page/image', 'title' => 'افزودن عکس به گالری']);
        Url::create(['parent_id' => $award_page->id, 'url' => 'admin/service/award/page/image/delete', 'title' => 'حذف عکس از گالری']);
        //Award Types
        $award_types = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'نوع جوایز']);
        Url::create(['parent_id' => $award_types->id, 'url' => 'admin/award/manage', 'title' => 'مدیریت جوایز']);
        Url::create(['parent_id' => $award_types->id, 'url' => 'admin/award/create', 'title' => 'ایجاد جایزه']);
        Url::create(['parent_id' => $award_types->id, 'url' => 'admin/award/edit/id/{id}', 'title' => 'ویرایش جایزه']);
        //Slider
        $slider = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'اسلایدر']);
        Url::create(['parent_id' => $slider->id, 'url' => 'admin/slider/manage', 'title' => 'مدیریت اسلایدها']);
        Url::create(['parent_id' => $slider->id, 'url' => 'admin/slider/create', 'title' => 'افزودن اسلاید']);
        Url::create(['parent_id' => $slider->id, 'url' => 'admin/slider/edit/id/{id}', 'title' => 'ویرایش اسلاید']);
        Url::create(['parent_id' => $slider->id, 'url' => 'admin/slider/delete/id/{id}', 'title' => 'حذف اسلاید']);
        //Content
        $variable = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'محتوا']);
        Url::create(['parent_id' => $variable->id, 'url' => 'admin/content/manage', 'title' => 'مدیریت محتوا']);
        Url::create(['parent_id' => $variable->id, 'url' => 'admin/content/create', 'title' => 'ایجاد محتوا']);
        Url::create(['parent_id' => $variable->id, 'url' => 'admin/content/edit/id/{id}', 'title' => 'ویرایش محتوا']);
        Url::create(['parent_id' => $variable->id, 'url' => 'admin/content/delete/id/{id}', 'title' => 'حذف محتوا']);
        //User
        $user = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'کاربران']);
        Url::create(['parent_id' => $user->id, 'url' => 'admin/user/manage', 'title' => 'مدیریت کاربران']);
        Url::create(['parent_id' => $user->id, 'url' => 'admin/user/edit/id/{id}', 'title' => 'ویرایش کاربر']);
        //Role
        $role = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'نقش']);
        Url::create(['parent_id' => $role->id, 'url' => 'admin/role/manage', 'title' => 'مدیریت نقش‌ها']);
        Url::create(['parent_id' => $role->id, 'url' => 'admin/role/create', 'title' => 'ایجاد نقش']);
        Url::create(['parent_id' => $role->id, 'url' => 'admin/role/edit/id/{id}', 'title' => 'ویراش نقش']);
        Url::create(['parent_id' => $role->id, 'url' => 'admin/role/delete/id/{id}', 'title' => 'حذف نقش']);
        //Url
        $url = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'URL']);
        Url::create(['parent_id' => $url->id, 'url' => 'admin/url/manage', 'title' => 'مدیریت URL ‌ها']);
        Url::create(['parent_id' => $url->id, 'url' => 'admin/url/create', 'title' => 'افزودن URL']);
        Url::create(['parent_id' => $url->id, 'url' => 'admin/url/edit/id/{id}', 'title' => 'ویراش URL']);
        Url::create(['parent_id' => $url->id, 'url' => 'admin/url/delete/id/{id}', 'title' => 'حذف URL']);
    }
}
