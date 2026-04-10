<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReqbalanceToHrLeavetypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_leavetypes', function (Blueprint $table) {
            //
            $table->string('RequiresBalance')->default("")->nullable()->after('LeaveType');
            $table->string('LeavePaymentType')->default("")->nullable()->after('RequiresBalance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_leavetypes', function (Blueprint $table) {
            //
            $table->dropColumn("RequiresBalance");
            $table->dropColumn("LeavePaymentType");
        });
    }
}
