<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddScheduletypeToShiftscheduledetails extends Migration
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
            $table->integer('ScheduleType')->default(0)->nullable()->after('ShiftFlag');
            $table->string('OldStatus')->default("")->nullable()->after('Status');
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
            $table->dropColumn("ScheduleType");
            $table->dropColumn("OldStatus");
        });
    }
}
