<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_statuses', function (Blueprint $table) {
            $table->id();

            $table->text('comment')->nullable();
            $table->unsignedBigInteger('complaint_id');
            $table->softDeletes();

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
        Schema::dropIfExists('comment_statuses');
    }
}
