<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRecdocToSettingsTable extends Migration
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
            $table->string('ProcReceivingOwnerPrefix')->default("")->nullable()->after('PrdCustomerNumber');
            $table->integer('ProcReceivingOwnerNumber')->default(1)->nullable()->after('ProcReceivingOwnerPrefix');
            $table->string('ProcReceivingCustomerPrefix')->default("")->nullable()->after('ProcReceivingOwnerNumber');
            $table->integer('ProcReceivingCustomerNumber')->default(1)->nullable()->after('ProcReceivingCustomerPrefix');
            $table->integer('ReceivingMode')->default(0)->nullable()->after('ProcReceivingCustomerNumber');
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
            $table->dropColumn("ProcReceivingOwnerPrefix");
            $table->dropColumn("ProcReceivingOwnerNumber");
            $table->dropColumn("ProcReceivingCustomerPrefix");
            $table->dropColumn("ProcReceivingCustomerNumber");
            $table->dropColumn("ReceivingMode");
        });
    }
}
