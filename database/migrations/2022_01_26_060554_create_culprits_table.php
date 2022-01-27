<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCulpritsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * Виновная сторона
     */
    public function up()
    {
        Schema::create('culprits', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('culprits');
    }
}
