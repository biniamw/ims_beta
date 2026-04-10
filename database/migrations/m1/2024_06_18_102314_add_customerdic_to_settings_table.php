<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomerdicToSettingsTable extends Migration
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
            $table->string('CommodityCusBeginningPrefix')->default("")->nullable()->after('CommodityBeginningPrefix');
            $table->integer('CommodityCusBeginningNumber')->default(0)->nullable()->after('CommodityCusBeginningPrefix');
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
            $table->dropColumn("CommodityCusBeginningPrefix");
            $table->dropColumn("CommodityCusBeginningNumber");
        });
    }
}
