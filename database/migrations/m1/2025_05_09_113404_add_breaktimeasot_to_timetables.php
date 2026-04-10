<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBreaktimeasotToTimetables extends Migration
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
            $table->integer('BreakTimeAsOvertime')->nullable()->default(0)->after('BreakTimeAsWorkTime');
            $table->integer('is_night_shift')->nullable()->default(0)->after('EndingOut');
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
            $table->dropColumn("BreakTimeAsOvertime");
            $table->dropColumn("is_night_shift");
        });
    }
}
