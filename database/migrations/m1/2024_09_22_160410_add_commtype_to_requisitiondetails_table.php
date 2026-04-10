<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommtypeToRequisitiondetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisitiondetails', function (Blueprint $table) {
            //
            $table->string('CommodityType')->default("")->nullable()->after('CommodityId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisitiondetails', function (Blueprint $table) {
            //
            $table->dropColumn("CommodityType");
        });
    }
}
