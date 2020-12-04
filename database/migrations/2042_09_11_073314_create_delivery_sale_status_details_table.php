<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverySaleStatusDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_sale_status_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_id')->unsigned();
            $table->integer('sale_status_id')->unsigned();
            $table->text('remark');
            $table->integer('created_by')->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('delivery_sale_status_details', function (Blueprint $table) {
            $table->foreign('sale_id')->references('id')->on('delivery_sales')->onDelete('cascade');
            $table->foreign('sale_status_id')->references('id')->on('delivery_sale_status')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_sale_status_details');
    }
}
