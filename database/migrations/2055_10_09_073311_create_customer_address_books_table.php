<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerAddressBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_address_books', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->string('contact_name',50);
            $table->string('location_name',100);
            $table->string('location_address',100);
            $table->char('Location_city_id');
            $table->string('pic_name',50);
            $table->string('pic_phone',50);
            $table->string('pic_email',100);
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('customer_address_books', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('location_city_id')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_address_books');
    }
}
