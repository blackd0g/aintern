<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileUploadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_upload', function (Blueprint $table) {
            $table->increments('id');
            $table->string('real_name', 50);
            $table->string('thumbnail_name', 50);
            $table->dateTime('time');
            $table->integer('width');
            $table->integer('height');
            $table->integer('gallery_id')
                ->references('id')
                ->on('gallery');
            $table->integer('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('file_upload');
    }
}
