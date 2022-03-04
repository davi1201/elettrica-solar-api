<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('city_id')->unsigned();
            $table->bigInteger('client_id')->unsigned();
            $table->string('zip_code')->nullable();
            $table->string('street');
            $table->string('number')->nullable();
            $table->string('neighborhood')->nullable();


            $table->enum('address_type', ['address', 'installation'])->default('address');
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
