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
            $table->date('close_at');
            $table->string('vehicle');          //вид надстройки

    /*        $table->foreignId('decree_id')->constrained(' '); //приказ*/
            $table->foreignId('warranty_types_id')->constrained('warranty_types');       //гарантия
            $table->foreignId('reason_id')->constrained('reasons');           //причина гар-ии
            $table->foreignId('type_comps_id')->constrained('type_comps');       //тип рекламации
            $table->foreignId('contractor_id')->constrained('contractors');       //контрагент
            $table->foreignId('culprit_id')->constrained('culprits');          //виновник
            $table->foreignId('executor_id')->constrained('executors');       //устранение
            $table->foreignId('status_id')->constrained('statuses');
            $table->foreignId('warranty_decree_id')->constrained('warranty_decrees');  //№ гар-го приказа


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
