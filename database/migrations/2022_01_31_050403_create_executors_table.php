<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExecutorsTable extends Migration
{
    /**
     * Run the migrations.
     * Устранение(справочник)
     * @return void
     */
    public function up()
    {
        Schema::create('executors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('executors');
    }
}
