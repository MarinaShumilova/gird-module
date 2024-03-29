<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_complaints', function (Blueprint $table) {
            $table->id();

            $table->text('warranty')->nullable();
            $table->text('prevention')->nullable();
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
        Schema::dropIfExists('event_complaints');
    }
}
