<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverySalePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_sale_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_id')->unsigned();
            $table->integer('price_sale_categories_id')->unsigned();
            $table->mediumInteger('price_sale')->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('delivery_sale_prices', function (Blueprint $table) {
            $table->foreign('sale_id')->references('id')->on('delivery_sales')->onDelete('cascade');
            $table->foreign('price_sale_categories_id')->references('id')->on('delivery_price_sale_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_sale_prices');
    }
}
