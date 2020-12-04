<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSelfMoverCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('self_mover_costs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('self_mover_id')->unsigned();
            $table->integer('cost_category_id')->unsigned();
            $table->mediumInteger('cost')->unsigned();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('self_mover_costs', function (Blueprint $table) {
            $table->foreign('self_mover_id')->references('id')->on('self_movers')->onDelete('cascade');
            $table->foreign('cost_category_id')->references('id')->on('cost_categories')->onDelete('cascade');
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('self_mover_costs');
    }
}
