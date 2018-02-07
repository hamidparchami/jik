<?php

use App\Url;
use Illuminate\Database\Seeder;

class ContentCategoryUrlsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Content Category
        $content_category = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'دسته بندی محتوا']);
        Url::create(['parent_id' => $content_category->id, 'url' => 'admin/content-category/manage', 'title' => 'مدیریت دسته بندی محتوا']);
        Url::create(['parent_id' => $content_category->id, 'url' => 'admin/content-category/create', 'title' => 'دسته جدید']);
        Url::create(['parent_id' => $content_category->id, 'url' => 'admin/content-category/edit/id/{id}', 'title' => 'ویرایش دسته']);
        Url::create(['parent_id' => $content_category->id, 'url' => 'admin/content-category/delete/id/{id}', 'title' => 'حذف دسته']);
    }
}
