<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWorkingminToEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            //
            $table->double('WorkingMinute')->default(0)->nullable()->after('CostSharingDeduction');
            $table->double('PensionPercent')->default(0)->nullable()->after('WorkingMinute');
            $table->double('AllowancePercent')->default(0)->nullable()->after('PensionPercent');
            $table->string('GuarantorName')->default("")->nullable()->after('EmergencyAddress');
            $table->string('GuarantorPhone')->default("")->nullable()->after('GuarantorName');
            $table->string('GuarantorAddress')->default("")->nullable()->after('GuarantorPhone');
            $table->string('GuarantorDocument')->default("")->nullable()->after('SignedContractDocument');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            //
            $table->dropColumn('WorkingMinute');
            $table->dropColumn('PensionPercent');
            $table->dropColumn('AllowancePercent');
            $table->dropColumn('GuarantorName');
            $table->dropColumn('GuarantorPhone');
            $table->dropColumn('GuarantorAddress');
            $table->dropColumn('GuarantorDocument');
        });
    }
}
