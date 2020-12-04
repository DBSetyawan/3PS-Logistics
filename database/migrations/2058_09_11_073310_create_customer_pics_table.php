<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerPicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_pics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->integer('customer_id')->unsigned();
            $table->integer('customer_pic_status_id')->unsigned();
            $table->string('position',50);
            $table->string('email',50);
            $table->string('phone',50);
            $table->string('mobile_phone',50);
            $table->timestamps();
        });
        Schema::table('customer_pics', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('customer_pic_status_id')->references('id')->on('customer_pic_status')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_pics');
    }
}
