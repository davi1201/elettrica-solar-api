<?php

use Facade\Ignition\Tabs\Tab;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePreInspectionAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pre_inspection_attachments', function (Blueprint $table) {
            $table->enum('status', ['approved', 'rejected'])->default('approved')->after('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pre_inspection_attachments', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
