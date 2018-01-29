<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('service_id');
            $table->unsignedInteger('award_type_id');
            $table->string('title');
            $table->string('description');
            $table->string('image');
            $table->unsignedInteger('order')->default(0);
            $table->unsignedInteger('count')->default(0);
            $table->unsignedInteger('minimum_point')->default(0);
            $table->unsignedInteger('price')->default(0);
            $table->date('display_date_start')->nullable();
            $table->date('display_date_end')->nullable();
            $table->tinyInteger('is_important')->default(1);
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
        Schema::dropIfExists('awards');
    }
}
