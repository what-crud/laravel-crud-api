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
            $table->string('firstname', 500);
            $table->string('lastname', 500);
            $table->boolean('company')->default(false);
            $table->string('registration_number')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email', 200);
            $table->string('street', 200)->nullable();
            $table->string('zip_code', 10)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('comments', 2000)->nullable();
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
        //
    }
}
