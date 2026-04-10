<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDispdocToSettingsTable extends Migration
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
            $table->string('DispDocOwnerPrefix')->default("")->nullable()->after('CommReqCustomerNumber');
            $table->integer('DispDocOwnerNumber')->default(1)->nullable()->after('DispDocOwnerPrefix');
            $table->string('DispDocCustomerPrefix')->default("")->nullable()->after('DispDocOwnerNumber');
            $table->integer('DispDocCustomerNumber')->default(1)->nullable()->after('DispDocCustomerPrefix');
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
            $table->dropColumn("DispDocOwnerPrefix");
            $table->dropColumn("DispDocOwnerNumber");
            $table->dropColumn("DispDocCustomerPrefix");
            $table->dropColumn("DispDocCustomerNumber");
        });
    }
}
