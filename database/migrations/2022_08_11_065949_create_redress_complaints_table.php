<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedressComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redress_complaints', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expenses_redress');
            $table->date('redress_at');
            $table->text('comment')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('complaint_id');
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
        Schema::dropIfExists('redress_complaints');
    }
}
