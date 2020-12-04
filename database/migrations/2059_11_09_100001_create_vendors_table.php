<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vendor_id');
            $table->integer('industry_id')->unsigned();
            $table->string('since',4);
            $table->string('director',50);
            $table->string('address',100);
            $table->char('city_id',4);
            $table->string('phone',50);
            $table->string('fax',50);
            $table->string('company_name',50);
            $table->string('type_of_business',50);
            $table->string('no_npwp',50);
            $table->string('address_npwp',50);
            $table->string('no_phone_npwp',50);
            $table->string('no_fax_npwp',50);
            $table->string('city_npwp',50);
            $table->string('fax_npwp',50);
            $table->string('nama_pic',50);
            $table->string('title_name_pic',50);
            $table->string('no_pic',50);
            $table->string('bank_name',50);
            $table->string('norek',50);
            $table->string('an_bank',50);
            $table->integer('term_of_payment')->unsigned();
            $table->string('email')->unique();
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

        Schema::table('vendors', function (Blueprint $table) {
            $table->foreign('industry_id')->references('id')->on('industrys')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('status_id')->references('id')->on('vendor_status')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
