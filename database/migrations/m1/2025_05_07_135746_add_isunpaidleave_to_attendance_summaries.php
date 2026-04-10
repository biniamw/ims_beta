<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsunpaidleaveToAttendanceSummaries extends Migration
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
            $table->integer('is_unpaid_leave')->nullable()->default(0)->after('IsPayrollMade');
            $table->integer('is_leave_half_day')->nullable()->default(0)->after('is_unpaid_leave');
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
            $table->dropColumn("is_unpaid_leave");
            $table->dropColumn("is_leave_half_day");
        });
    }
}
