<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vendor_id')->unsigned();
            $table->integer('moverable_id');
            $table->string('moverable_type',100);
            $table->string('pr_no',50);
            $table->string('po_no',50);
            $table->string('invoice_no',50);
            $table->string('invoice_status',50);
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('movers', function (Blueprint $table) {
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movers');
    }
}
