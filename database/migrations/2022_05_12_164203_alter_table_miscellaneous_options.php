<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableMiscellaneousOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('miscellaneous_options', function (Blueprint $table) {
            $table->string('solfacil_ref')->nullable()->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('miscellaneous_options', function (Blueprint $table) {
            $table->dropColumn('solfacil_ref');
        });
    }
}
