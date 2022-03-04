<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('agent_id')->unsigned()->nullable();
            $table->bigInteger('client_id')->unsigned();
            $table->integer('roof_type_id')->unsigned()->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('price_cost', 10, 2);
            $table->boolean('active')->default(true);
            $table->timestamps();

            $table->foreign('agent_id')->references('id')->on('agents');
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('roof_type_id')->references('id')->on('miscellaneous_options');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
