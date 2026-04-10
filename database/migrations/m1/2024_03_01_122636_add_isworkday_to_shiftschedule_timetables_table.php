<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsworkdayToShiftscheduleTimetablesTable extends Migration
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
            $table->integer('isworkday')->nullable()->default(1)->after('Date');
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
            $table->dropColumn('isworkday');
        });
    }
}
