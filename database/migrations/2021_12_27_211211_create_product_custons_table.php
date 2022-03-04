<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCustonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_custons', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('inverter');
            $table->decimal('inverter_power', 10, 2);
            $table->integer('inverter_quantity');
            $table->string('supplier');
            $table->string('panel');
            $table->decimal('panel_power', 10, 2);
            $table->integer('panel_quantity');
            $table->string('structure');
            $table->string('transformer')->nullable();
            $table->string('transformer_kva')->nullable();
            $table->string('transformer_quantity')->nullable();
            $table->integer('string_box_input');
            $table->integer('string_box_output');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('product_custons');
    }
}
