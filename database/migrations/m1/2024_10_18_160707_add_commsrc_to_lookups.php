<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommsrcToLookups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lookups', function (Blueprint $table) {
            //
            $table->string('CommoditySourceValue')->default("")->nullable()->after('DispatchModeStatus');
            $table->string('CommoditySource')->default("")->nullable()->after('CommoditySourceValue');
            $table->string('CommoditySourceStatus')->default("")->nullable()->after('CommoditySource');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lookups', function (Blueprint $table) {
            //
            $table->dropColumn("CommoditySourceValue");
            $table->dropColumn("CommoditySource");
            $table->dropColumn("CommoditySourceStatus");
        });
    }
}
