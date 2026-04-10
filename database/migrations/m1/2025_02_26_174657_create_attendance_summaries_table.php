<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_summaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employees_id')->constrained();
            $table->string('Date')->nullable();
            $table->double('WorkingTimeAmount')->default(0)->nullable();
            $table->double('BreakTimeAmount')->default(0)->nullable();
            $table->double('BeforeOvertimeAmount')->default(0)->nullable();
            $table->double('AfterOvertimeAmount')->default(0)->nullable();
            $table->double('TotalOvertimeAmount')->default(0)->nullable();
            $table->double('LateCheckInTimeAmount')->default(0)->nullable();
            $table->double('EarlyCheckOutTimeAmount')->default(0)->nullable();
            $table->double('BeforeOnDutyTimeAmount')->default(0)->nullable();
            $table->double('AfterOffDutyTimeAmount')->default(0)->nullable();
            $table->double('OffShiftOvertime')->default(0)->nullable();
            $table->double('OffShiftOvertimeLevelPercent')->default(0)->nullable();
            $table->integer('Status')->default(0)->nullable();
            $table->JSON('AllStatus')->nullable();
            $table->integer('IsPayrollMade')->default(0)->nullable();
            $table->string('Remark',"65535")->nullable();
            $table->string('OffShiftStatus')->nullable();
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
        Schema::dropIfExists('attendance_summaries');
    }
}
