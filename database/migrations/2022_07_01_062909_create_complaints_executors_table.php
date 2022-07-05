<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsExecutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints_executors', function (Blueprint $table) {

            $table->unsignedBigInteger('complaint_id');
            $table->unsignedBigInteger('executor_id');

            $table->foreign('complaint_id')->references('id')->on('complaints');
            $table->foreign('executor_id')->references('id')->on('executors');

            $table->primary(['complaint_id','executor_id']);


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaints_executors');
    }
}
