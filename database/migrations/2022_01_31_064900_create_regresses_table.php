<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regresses', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedBigInteger('complaint_id');

            $table->foreign('complaint_id')->references('id')->on('complaints');

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
        Schema::dropIfExists('regresses');
    }
}
