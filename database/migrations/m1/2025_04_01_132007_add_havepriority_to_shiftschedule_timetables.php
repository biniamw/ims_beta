<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHavepriorityToShiftscheduleTimetables extends Migration
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
            $table->integer('have_priority')->default(0)->nullable()->after('isworkday');
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
            $table->dropColumn("have_priority");
        });
    }
}
