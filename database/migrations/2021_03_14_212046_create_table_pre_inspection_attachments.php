<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePreInspectionAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_inspection_attachments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('project_id')->unsigned();
            $table->integer('file_entry_id')->unsigned();
            $table->string('type');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('file_entry_id')->references('id')->on('file_entries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_inspection_attachments');
    }
}
