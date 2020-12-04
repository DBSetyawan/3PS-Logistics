<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobmoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobmovers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->unsigned();
            $table->integer('sub_service_id')->unsigned();
            $table->char('origin_id');
            $table->char('destination_id');
            $table->integer('jobmoverable_id');
            $table->string('jobmoverable_type',100);
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::table('jobmovers', function (Blueprint $table) {
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('cascade');
            $table->foreign('sub_service_id')->references('id')->on('sub_services')->onDelete('cascade');
            $table->foreign('origin_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('destination_id')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobmovers');
    }
}
