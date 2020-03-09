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
        /**
         * Q: queued
         * F: failed
         * S: send
         * D: delivered
         * U: undelivered
         * R: received
         */
        Schema::create('contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('from_number');
            $table->string('to_number');
            $table->text('content');
            $table->integer('u_id')->nullable();
            $table->integer('c_id')->nullable();
            // $table->enum('status', ['Q','F', 'S', 'D', 'U', 'R'])->nullable();
            $table->string('status');
            $table->string('sid')->nullable(); // sid: sms id
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
