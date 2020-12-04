<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',100);
            $table->integer('industry_id')->unsigned();
            $table->string('since',4);
            $table->string('director',50);
            $table->string('address',100);
            $table->char('city_id',4);
            $table->string('phone',50);
            $table->string('fax',50);
            $table->string('email',50);
            $table->string('website',50);
            $table->string('tax_no',50);
            $table->string('tax_address',50);
            $table->string('tax_city',50);
            $table->string('tax_phone',50);
            $table->string('tax_fax',50);
            $table->integer('status_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();

        });
        Schema::table('customers', function (Blueprint $table) {
            $table->foreign('industry_id')->references('id')->on('industrys')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('customer_status')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
