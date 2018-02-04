<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('category_id')->nullable();
            $table->string('title')->nullable();
            $table->text('short_content')->nullable();
            $table->text('content')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('robots_follow_type')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('is_important')->default(0);
            $table->tinyInteger('can_comment')->default(0);
            $table->tinyInteger('can_like')->default(0);
            $table->date('publish_date_start')->nullable();
            $table->date('publish_date_end')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
