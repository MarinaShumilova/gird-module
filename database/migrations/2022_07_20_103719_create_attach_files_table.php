<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attach_files', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('name');
            $table->string('extension');
            $table->string('type');

            $table->unsignedBigInteger('firm_id')->nullable();
            $table->unsignedBigInteger('type_pact_id')->nullable();

            $table->foreign('firm_id')->references('id')->on('firms');
            $table->foreign('type_pact_id')->references('id')->on('type_pacts');

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
        Schema::dropIfExists('attach_files');
    }
}
