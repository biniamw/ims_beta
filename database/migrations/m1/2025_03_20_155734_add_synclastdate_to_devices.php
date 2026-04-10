<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSynclastdateToDevices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('devices', function (Blueprint $table) {
            //
            $table->string('ManualSyncLatestTime')->default("")->nullable()->after('Description');
            $table->string('AutoSyncLatestTime')->default("")->nullable()->after('ManualSyncLatestTime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('devices', function (Blueprint $table) {
            //
            $table->dropColumn("ManualSyncLatestTime");
            $table->dropColumn("AutoSyncLatestTime");
        });
    }
}
