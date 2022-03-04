<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('codigo', 50)->primary();
            $table->string('marca')->nullable();
            $table->string('telhado')->nullable();
            $table->string('categoria')->nullable();
            $table->string('descricao')->nullable();
            $table->string('unidade')->nullable();
            $table->decimal('preco', 15, 2)->nullable();
            $table->decimal('precoeup', 15, 2)->nullable();
            $table->float('peso')->nullable();
            $table->longText('descricao_tecnica')->nullable();
            $table->string('foto')->nullable();
            $table->float('potencia')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('products');
    }
}
