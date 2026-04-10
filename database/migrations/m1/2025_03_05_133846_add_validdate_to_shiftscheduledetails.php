<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddValiddateToShiftscheduledetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shiftscheduledetails', function (Blueprint $table) {
            //
            $table->string('ValidDate')->nullable()->after('shifts_id');
            $table->string('CheckInNotReq')->nullable()->after('ValidDate');
            $table->string('CheckOutNotReq')->nullable()->after('CheckInNotReq');
            $table->string('ScheduleOnHoliday')->nullable()->after('CheckOutNotReq');
            $table->string('EffectiveOt')->nullable()->after('ScheduleOnHoliday');
            $table->string('ShiftFlag')->nullable()->after('EffectiveOt');
            $table->string('Status')->nullable()->after('ShiftFlag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shiftscheduledetails', function (Blueprint $table) {
            //
            $table->dropColumn("ValidDate");
            $table->dropColumn("CheckInNotReq");
            $table->dropColumn("CheckOutNotReq");
            $table->dropColumn("ScheduleOnHoliday");
            $table->dropColumn("EffectiveOt");
            $table->dropColumn("ShiftFlag");
            $table->dropColumn("Status");
        });
    }
}
