<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnProjectCustonProjectProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_products', function (Blueprint $table) {
            $table->bigInteger('product_custon_id')->unsigned()->nullable()->after('project_id');

            $table->foreign('product_custon_id')->references('id')->on('product_custons');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_products', function (Blueprint $table) {
            //
        });
    }
}
