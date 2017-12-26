<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')
                ->references('id')
                ->on('users');
            $table->string('actions', 50);
            $table->string('status', 50);
            $table->string('target', 50);
            $table->integer('target_id');
            $table->dateTime('time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('upload_log');
    }
}
