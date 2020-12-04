<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliverySalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->integer('company_branch_id')->unsigned();
            $table->integer('sub_service_id')->unsigned();
            $table->integer('sale_origin_customer_address_book_id')->unsigned();
            $table->integer('sale_destination_customer_address_book_id')->unsigned();
            $table->mediumInteger('total_price')->unsigned();
            $table->float('actual_weight')->unsigned();
            $table->float('volume_weight')->unsigned();
            $table->float('chargeable_weight')->unsigned();
            $table->dateTime('rtd');
            $table->dateTime('rta');
            $table->string('reff',50);
            $table->text('remark');
            $table->integer('sale_status_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('delivery_sales', function (Blueprint $table) {
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('company_branch_id')->references('id')->on('company_branchs')->onDelete('cascade');
            $table->foreign('sub_service_id')->references('id')->on('sub_services')->onDelete('cascade');
            $table->foreign('sale_origin_customer_address_book_id')->references('id')->on('customer_address_books')->onDelete('cascade');
            $table->foreign('sale_destination_customer_address_book_id')->references('id')->on('customer_address_books')->onDelete('cascade');
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
        Schema::dropIfExists('delivery_sales');
    }
}
