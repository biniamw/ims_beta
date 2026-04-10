<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocnumToSettingsTable extends Migration
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
            $table->string('CommReqOwnerPrefix')->default("")->nullable()->after('ReceivingMode');
            $table->integer('CommReqOwnerNumber')->default(1)->nullable()->after('CommReqOwnerPrefix');
            $table->string('CommReqCustomerPrefix')->default("")->nullable()->after('CommReqOwnerNumber');
            $table->integer('CommReqCustomerNumber')->default(1)->nullable()->after('CommReqCustomerPrefix');
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
            $table->dropColumn("CommReqOwnerPrefix");
            $table->dropColumn("CommReqOwnerNumber");
            $table->dropColumn("CommReqCustomerPrefix");
            $table->dropColumn("CommReqCustomerNumber");
        });
    }
}
