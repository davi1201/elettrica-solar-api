<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProjectTransformers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('project_transformers')) {
            Schema::create('project_transformers', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('project_id')->unsigned();
                $table->string('product_code',50);
                $table->integer('quantity');
                $table->timestamps();

                $table->foreign('project_id')->references('id')->on('projects');
                $table->foreign('product_code')->references('codigo')->on('products');
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_transformers');
    }
}
