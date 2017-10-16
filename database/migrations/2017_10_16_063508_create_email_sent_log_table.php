<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailSentLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_sent_logs', function (Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->string('to_email')->nullable();
            $table->string('cc_emails', 512)->nullable();
            $table->string('bcc_emails')->nullable();
            $table->string('from_email')->nullable();
            $table->string('email_subject')->nullable();
            $table->text('email_body')->nullable();
            $table->text('mail_response')->nullable();
            $table->string('status', 32)->nullable()->default('sent')->comment('0 = fail 1 = success 2 = pending');
            
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
        Schema::dropIfExists('email_sent_logs');
    }
}
