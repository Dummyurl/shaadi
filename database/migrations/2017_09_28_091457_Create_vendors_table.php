<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_type_id')->unsigned()->nullable();
            $table->integer('vendor_category_id')->unsigned()->nullable();
            $table->string('name')->nullable()->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('address')->nullable();
            $table->integer('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->integer('city_id')->unsigned()->nullable();
            $table->integer('status')->nullable()->default(1);
            $table->string('slug')->nullable();
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
        Schema::dropIfExists('vendors');
    }
}
