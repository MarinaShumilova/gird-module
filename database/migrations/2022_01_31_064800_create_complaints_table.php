<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();

            $table->date('start_at');
            $table->date('close_at')->nullable();
            $table->softDeletes();

            $table->string('vehicle');          //вид надстройки
            $table->string('numb_order')->comment('номер приказа');
            $table->date('order_at')->comment('дата приказа');

            $table->date('unload_at')->comment('дата отгрузки');



            $table->string('warranty_decree')->nullable()->comment('№ гар-го приказа');
            $table->unsignedBigInteger('warranty_type_id')->comment('гарантия');
            $table->unsignedBigInteger('reason_id')->comment('причина гар-ии');
            $table->unsignedBigInteger('type_comp_id')->comment('тип рекламации');
            $table->unsignedBigInteger('contractor_id')->comment('контрагент');
            $table->unsignedBigInteger('culprit_id')->comment('виновник');
            $table->unsignedBigInteger('status_id')->comment('статус');




            $table->foreign('warranty_type_id')->references('id')->on('warranty_types');
            $table->foreign('reason_id')->references('id')->on('reasons');
            $table->foreign('type_comp_id')->references('id')->on('type_comps');
            $table->foreign('contractor_id')->references('id')->on('contractors');
            $table->foreign('culprit_id')->references('id')->on('culprits');
            $table->foreign('status_id')->references('id')->on('statuses');
            ;




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
        Schema::dropIfExists('complaints');
    }

}
