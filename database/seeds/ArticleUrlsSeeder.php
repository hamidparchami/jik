<?php

use App\Url;
use Illuminate\Database\Seeder;

class ArticleUrlsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Article Category
        $article_category = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'دسته بندی مطالب']);
        Url::create(['parent_id' => $article_category->id, 'url' => 'admin/article-category/manage', 'title' => 'مدیریت دسته بندی مطالب']);
        Url::create(['parent_id' => $article_category->id, 'url' => 'admin/article-category/create', 'title' => 'دسته جدید']);
        Url::create(['parent_id' => $article_category->id, 'url' => 'admin/article-category/edit/id/{id}', 'title' => 'ویرایش دسته']);
        Url::create(['parent_id' => $article_category->id, 'url' => 'admin/article-category/delete/id/{id}', 'title' => 'حذف دسته']);
        //Article
        $article = Url::create(['parent_id' => 0, 'url' => '', 'title' => 'مطالب']);
        Url::create(['parent_id' => $article->id, 'url' => 'admin/article/manage', 'title' => 'مدیریت مطالب']);
        Url::create(['parent_id' => $article->id, 'url' => 'admin/article/create', 'title' => 'مطلب جدید']);
        Url::create(['parent_id' => $article->id, 'url' => 'admin/article/edit/id/{id}', 'title' => 'ویرایش مطلب']);
        Url::create(['parent_id' => $article->id, 'url' => 'admin/article/delete/id/{id}', 'title' => 'حذف مطلب']);
    }
}
