<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSideCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('side_companies', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->unsignedBigInteger('complaint_id');



            $table->foreign('complaint_id')->references('id')->on('complaints');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('side_companies');
    }
}
