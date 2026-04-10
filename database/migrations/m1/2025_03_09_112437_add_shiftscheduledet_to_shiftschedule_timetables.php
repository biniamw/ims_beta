<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShiftscheduledetToShiftscheduleTimetables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shiftschedule_timetables', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('shiftscheduledetails_id')->nullable()->after('shiftschedules_id');
            $table->integer('OldTimetable')->default(0)->nullable()->after('isworkday');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shiftschedule_timetables', function (Blueprint $table) {
            //
            $table->dropColumn("shiftscheduledetails_id");
            $table->dropColumn("OldTimetable");
        });
    }
}
