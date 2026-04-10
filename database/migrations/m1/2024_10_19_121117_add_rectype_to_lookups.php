<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRectypeToLookups extends Migration
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
            $table->string('ReceivingTypeValue')->default("")->nullable()->after('CommoditySourceStatus');
            $table->string('ReceivingType')->default("")->nullable()->after('ReceivingTypeValue');
            $table->string('ReceivingTypeStatus')->default("")->nullable()->after('ReceivingType');
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
            $table->dropColumn("ReceivingTypeValue");
            $table->dropColumn("ReceivingType");
            $table->dropColumn("ReceivingTypeStatus");
        });
    }
}
