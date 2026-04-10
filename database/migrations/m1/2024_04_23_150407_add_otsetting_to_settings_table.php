<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtsettingToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->foreignId('overtime_dayoff_id')->default(1)->constrained('overtimes')->after('defaultpic');
            $table->foreignId('overtime_holiday_id')->default(1)->constrained('overtimes')->after('overtime_dayoff_id');
            $table->double('WorkingMinute')->default(0)->nullable()->after('overtime_holiday_id');
            $table->integer('PayrollCalendarType')->default(0)->nullable()->after('WorkingMinute');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->dropColumn('overtime_dayoff_id');
            $table->dropColumn('overtime_holiday_id');
            $table->dropColumn('WorkingMinute');
            $table->dropColumn('PayrollCalendarType');
        });
    }
}
