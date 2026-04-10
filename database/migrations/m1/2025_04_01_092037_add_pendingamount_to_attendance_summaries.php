<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPendingamountToAttendanceSummaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendance_summaries', function (Blueprint $table) {
            //
            $table->double('WorkHourPending')->default(0)->nullable()->after('OffShiftOvertimeLevelPercent');
            $table->double('BreakHourPending')->default(0)->nullable()->after('WorkHourPending');
            $table->double('OvertimePending')->default(0)->nullable()->after('BreakHourPending');
            $table->double('LateCheckInPending')->default(0)->nullable()->after('OvertimePending');
            $table->double('EarlyCheckOutPending')->default(0)->nullable()->after('LateCheckInPending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance_summaries', function (Blueprint $table) {
            //
            $table->dropColumn("WorkHourPending");
            $table->dropColumn("BreakHourPending");
            $table->dropColumn("OvertimePending");
            $table->dropColumn("LateCheckInPending");
            $table->dropColumn("EarlyCheckOutPending");
        });
    }
}
