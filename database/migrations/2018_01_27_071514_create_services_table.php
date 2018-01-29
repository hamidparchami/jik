<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('catalog_id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('short_description')->nullable();
            $table->string('price_description')->nullable();
            $table->string('manual_register_description')->nullable();
            $table->string('increase_points_description')->nullable();
            $table->string('disable_service_description')->nullable();
            $table->string('cover_image');
            $table->string('icon')->nullable();
            $table->text('welcome_message');
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->date('display_awards_date_start')->nullable();
            $table->date('display_awards_date_end')->nullable();
            $table->tinyInteger('is_active')->default(1);
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
        Schema::dropIfExists('services');
    }
}
