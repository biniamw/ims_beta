<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBreakToShiftdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shiftdetails', function (Blueprint $table) {
            //
            $table->string('BreakStartTime')->nullable()->default("")->after('BlLateEndTime');
            $table->string('BreakEndTime')->nullable()->default("")->after('BreakStartTime');
            $table->string('BreakHour')->nullable()->default("")->after('BreakEndTime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shiftdetails', function (Blueprint $table) {
            //
            $table->dropColumn('BreakStartTime');
            $table->dropColumn('BreakEndTime');
            $table->dropColumn('BreakHour');
        });
    }
}
