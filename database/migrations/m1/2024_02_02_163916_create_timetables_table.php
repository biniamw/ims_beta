<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->string('TimetableName')->nullable();
            $table->string('PunchingMethod')->nullable();
            $table->integer('BreakTimeAsWorkTime')->nullable()->default(0);
            $table->integer('EarlyCheckInOvertime')->nullable()->default(0);
            $table->string('OnDutyTime')->nullable();
            $table->string('OffDutyTime')->nullable();
            $table->string('WorkTime')->nullable();
            $table->integer('LateTime')->nullable()->default(0);
            $table->integer('LeaveEarlyTime')->nullable()->default(0);
            $table->string('BeginningIn')->nullable();
            $table->string('EndingIn')->nullable();
            $table->string('BeginningOut')->nullable();
            $table->string('EndingOut')->nullable();
            $table->string('OvertimeStart')->nullable();
            $table->string('BreakStartTime')->nullable();
            $table->string('BreakEndTime')->nullable();
            $table->string('BreakHour')->nullable();
            $table->string('CheckInLateMinute')->nullable();
            $table->string('CheckOutEarlyMinute')->nullable();
            $table->integer('NoCheckInFlag')->nullable()->default(0);
            $table->string('NoCheckInMinute')->nullable();
            $table->integer('NoCheckOutFlag')->nullable()->default(0);
            $table->string('NoCheckOutMinute')->nullable();
            $table->string('TimetableColor')->nullable();
            $table->string('Description',"65535")->nullable();
            $table->string('CreatedBy')->default("")->nullable();
            $table->string('LastEditedBy')->default("")->nullable();
            $table->string('LastEditedDate')->default("")->nullable();
            $table->string('Status')->default("")->nullable();
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
        Schema::dropIfExists('timetables');
    }
}
