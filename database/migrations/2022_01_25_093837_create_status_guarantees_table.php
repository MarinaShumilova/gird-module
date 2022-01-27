<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusGuaranteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * Статус гарантии
     */
    public function up()
    {
        Schema::create('status_guarantees', function (Blueprint $table) {
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
        Schema::dropIfExists('status_guarantees');
    }
}
