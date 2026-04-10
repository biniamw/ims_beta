<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBreakflagToTimetables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('timetables', function (Blueprint $table) {
            //
            $table->integer('BreakHourFlag')->default(0)->nullable()->after('OvertimeStart');
            $table->integer('LateTimeBreak')->default(0)->nullable()->after('LateTime');
            $table->integer('LeaveEarlyTimeBreak')->default(0)->nullable()->after('LateTimeBreak');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timetables', function (Blueprint $table) {
            //
            $table->dropColumn("BreakHourFlag");
            $table->dropColumn("LateTimeBreak");
            $table->dropColumn("LeaveEarlyTimeBreak");
        });
    }
}
