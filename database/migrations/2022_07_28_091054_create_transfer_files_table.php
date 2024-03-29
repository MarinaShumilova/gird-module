<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_files', function (Blueprint $table) {
            $table->id();
            $table->date('transfer_at');
            $table->text('comment')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('transfer_files');
    }
}
