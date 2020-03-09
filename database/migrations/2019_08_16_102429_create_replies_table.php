<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('SmsMessageSid');
            $table->string('NumMedia');
            $table->string('SmsSid');
            $table->string('SmsStatus');
            $table->string('Body');
            $table->string('To');
            $table->string('NumSegments');
            $table->string('MessageSid');
            $table->string('AccountSid');
            $table->string('From');
            $table->string('ApiVersion');
            $table->unsignedBigInteger('content_id');
            $table->foreign('content_id')->references('id')->on('contents');
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
        Schema::dropIfExists('replies');
    }
}
