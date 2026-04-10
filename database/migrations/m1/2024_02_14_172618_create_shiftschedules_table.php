<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftschedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shiftschedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employees_id')->constrained();
            $table->string('Date')->nullable();
            $table->integer('CheckInNotReq')->nullable()->default(0);
            $table->integer('CheckOutNotReq')->nullable()->default(0);
            $table->integer('ScheduleOnHoliday')->nullable()->default(0);
            $table->integer('EffectiveOt')->nullable()->default(0);
            $table->string('CreatedBy')->nullable();
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
        Schema::dropIfExists('shiftschedules');
    }
}
