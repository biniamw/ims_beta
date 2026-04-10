<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalsToHrLeaves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hr_leaves', function (Blueprint $table) {
            //
            $table->string('LeaveDurationType')->default("")->nullable()->after('RequestedDate');
            $table->string('LeaveReason')->default("")->nullable()->after('LeaveTo');
            $table->string('AddressDuringLeave')->default("")->nullable()->after('LeaveReason');
            $table->string('DocumentUpload')->default("")->nullable()->after('AddressDuringLeave');
            $table->string('EmergencyName')->default("")->nullable()->after('DocumentUpload');
            $table->string('EmergencyPhone')->default("")->nullable()->after('EmergencyName');
            $table->string('EmergencyEmail')->default("")->nullable()->after('EmergencyPhone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hr_leaves', function (Blueprint $table) {
            //
            $table->dropColumn("LeaveDurationType");
            $table->dropColumn("LeaveReason");
            $table->dropColumn("AddressDuringLeave");
            $table->dropColumn("DocumentUpload");
            $table->dropColumn("EmergencyName");
            $table->dropColumn("EmergencyPhone");
            $table->dropColumn("EmergencyEmail");
        });
    }
}
