<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 1000);
            $table->string('common_name', 150)->unique();
            $table->integer('company_type_id')->unsigned()->default(1);
            $table->foreign('company_type_id')->references('id')->on('company_types');
            $table->char('nip', 10)->nullable();
            $table->char('regon', 9)->nullable();
            $table->char('krs', 10)->nullable();
            $table->integer('street_prefix_id')->unsigned()->default(1);
            $table->foreign('street_prefix_id')->references('id')->on('street_prefixes')->nullable();
            $table->string('street', 255)->nullable();
            $table->string('house_number', 50)->nullable();
            $table->string('apartment_number', 50)->nullable();
            $table->char('zip_code', 6)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('borough', 255)->nullable();
            $table->string('county', 255)->nullable();
            $table->string('voivodship', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('web_page', 255)->nullable();
            $table->string('fax', 50)->nullable();
            $table->double('coordinates_lat')->nullable();
            $table->double('coordinates_lng')->nullable();
            $table->boolean('coordinates_checked')->nullable();
            $table->string('google_map_place', 300)->nullable();
            $table->integer('parent_company_id')->nullable();
            $table->integer('correspondence_street_prefix_id')->unsigned()->default(1);
            $table->foreign('correspondence_street_prefix_id')->references('id')->on('street_prefixes')->nullable();
            $table->string('correspondence_street', 255)->nullable();
            $table->string('correspondence_house_number', 50)->nullable();
            $table->string('correspondence_apartment_number', 50)->nullable();
            $table->char('correspondence_zip_code', 6)->nullable();
            $table->string('correspondence_city', 255)->nullable();
            $table->string('correspondence_borough', 255)->nullable();
            $table->string('correspondence_county', 255)->nullable();
            $table->string('correspondence_voivodship', 255)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
