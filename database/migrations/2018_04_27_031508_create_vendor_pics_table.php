<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorPicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_pics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->integer('vendor_id')->unsigned();
            $table->integer('vendor_pic_status_id')->unsigned();
            $table->string('position',50);
            $table->string('email',50);
            $table->string('phone',50);
            $table->string('mobile_phone',50);
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('vendor_pics', function (Blueprint $table) {
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->foreign('vendor_pic_status_id')->references('id')->on('vendor_pic_status')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_pics');
    }
}
