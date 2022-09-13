<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintCulpritsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint_culprits_tables', function (Blueprint $table) {
            $table->unsignedBigInteger('complaint_id');
            $table->unsignedBigInteger('culprit_id');

            $table->foreign('complaint_id')->references('id')->on('complaints');
            $table->foreign('culprit_id')->references('id')->on('culprits');

            $table->primary(['complaint_id','culprit_id']);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaint_culprits_tables');
    }
}
