<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftscheduleTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shiftschedule_timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shiftschedules_id')->constrained();
            $table->foreignId('shifts_id')->constrained();
            $table->foreignId('timetables_id')->constrained();
            $table->string('Date')->nullable();
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
        Schema::dropIfExists('shiftschedule_timetables');
    }
}
