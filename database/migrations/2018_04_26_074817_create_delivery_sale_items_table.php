<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverySaleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_sale_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_id')->unsigned();
            $table->text('name');
            $table->integer('quantity')->unsigned();
            $table->float('Lenght')->unsigned();
            $table->float('weight')->unsigned();
            $table->float('height')->unsigned();
            $table->float('width')->unsigned();
            $table->integer('quantity_load')->unsigned();
            $table->integer('sale_item_status_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->text('remark');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('delivery_sale_items', function (Blueprint $table) {
            $table->foreign('sale_id')->references('id')->on('delivery_sales')->onDelete('cascade');$table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('sale_item_status_id')->references('id')->on('delivery_sale_item_status')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_sale_items');
    }
}
