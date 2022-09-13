<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintReasonsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint_reasons_tables', function (Blueprint $table) {

            $table->unsignedBigInteger('complaint_id');
            $table->unsignedBigInteger('reason_id');

            $table->foreign('complaint_id')->references('id')->on('complaints');
            $table->foreign('reason_id')->references('id')->on('reasons');

            $table->primary(['complaint_id','reason_id']);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaint_reasons_tables');
    }
}
