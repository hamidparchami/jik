<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->text('text')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('video_url')->nullable();
            $table->string('audio_url')->nullable();
            $table->unsignedInteger('score')->nullable();
            $table->dateTime('publish_time')->nullable();
            $table->unsignedInteger('price')->nullable();
            $table->unsignedInteger('order')->nullable();
            $table->enum('type',['text', 'photo', 'video', 'audio']);
            $table->enum('send_type',['pull', 'push']);
            $table->enum('state',['pending', 'canceled', 'in_queue', 'failed','done']);
            $table->tinyInteger('is_active')->default(0);
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
        Schema::dropIfExists('contents');
    }
}
