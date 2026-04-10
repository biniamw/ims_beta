<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHeaderidToHrEmployeeLeaves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_employee_leaves', function (Blueprint $table) {
            //
            $table->integer('emp_leaveallocs_id')->default(0)->nullable()->after('id');
            $table->string('Year')->default("")->nullable()->after('hr_leavetypes_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_employee_leaves', function (Blueprint $table) {
            //
            $table->dropColumn("emp_leaveallocs_id");
            $table->dropColumn("Year");
        });
    }
}
