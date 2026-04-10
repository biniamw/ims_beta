<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employees_id')->constrained();
            $table->foreignId('timetables_id')->default(1)->constrained();
            $table->string('Date')->nullable();
            $table->string('Time')->nullable();
            $table->string('PunchInTime')->nullable();
            $table->string('PunchOutTime')->nullable();
            $table->double('WorkHour')->default(0)->nullable();
            $table->integer('TimeOpt')->default(0)->nullable();
            $table->string('BreakInTime')->nullable();
            $table->string('BreakOutTime')->nullable();
            $table->double('BreakHour')->default(0)->nullable();
            $table->integer('PunchType')->default(0)->nullable();
            $table->integer('IsBreakPunch')->default(0)->nullable();
            $table->integer('IsEarlyOvertimeCalc')->default(0)->nullable();
            $table->double('EarlyOvertime')->default(0)->nullable();
            $table->integer('IsLateOvertimeCalc')->default(0)->nullable();
            $table->double('LateOvertime')->default(0)->nullable();
            $table->integer('IsCheckInReq')->default(0)->nullable();
            $table->integer('IsCheckOutReq')->default(0)->nullable();
            $table->integer('TotalAssignedTimetable')->default(0)->nullable();
            $table->integer('ExpectedPunch')->default(0)->nullable();
            $table->integer('IsOnLeave')->default(0)->nullable();
            $table->integer('IsOnUnpaidLeave')->default(0)->nullable();
            $table->integer('AttendaceType')->default(0)->nullable();
            $table->integer('IsActualTimetable')->default(0)->nullable();
            $table->integer('IsPayrollMade')->default(0)->nullable();
            $table->string('Remark')->nullable();
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
        Schema::dropIfExists('attendances');
    }
}
