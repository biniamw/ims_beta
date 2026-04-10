<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActualsalaryToPayrolldetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payrolldetails', function (Blueprint $table) {
            //
            $table->double('actual_salary')->nullable()->default(0)->after('lateabsent_hr');
            $table->double('absent_day')->nullable()->default(0)->after('lateabsent_hr');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payrolldetails', function (Blueprint $table) {
            //
            $table->dropColumn("actual_salary");
            $table->dropColumn("absent_day");
        });
    }
}
