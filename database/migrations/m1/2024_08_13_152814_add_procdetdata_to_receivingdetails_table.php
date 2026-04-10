<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProcdetdataToReceivingdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receivingdetails', function (Blueprint $table) {
            //
            $table->string('CommodityId')->default()->nullable()->after('Common');
            $table->string("Grade")->default()->nullable()->after('CommodityId');
            $table->string("ProcessType")->default()->nullable()->after('Grade');
            $table->string("CropYear")->default()->nullable()->after('ProcessType');
            $table->double('NumOfBag')->default(0)->nullable()->after('CropYear');
            $table->double('TotalKg')->default(0)->nullable()->after('NumOfBag');
            $table->double('NetKg')->default(0)->nullable()->after('TotalKg');
            $table->double('Feresula')->default(0)->nullable()->after('NetKg');
            $table->double('VarianceShortage')->default("0")->nullable()->after('Feresula');
            $table->double('VarianceOverage')->default("0")->nullable()->after('VarianceShortage');
            $table->double('BagWeight')->default("0")->nullable()->after('VarianceOverage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receivingdetails', function (Blueprint $table) {
            //
            $table->dropColumn("CommodityId");
            $table->dropColumn("Grade");
            $table->dropColumn("ProcessType");
            $table->dropColumn("CropYear");
            $table->dropColumn("NumOfBag");
            $table->dropColumn("TotalKg");
            $table->dropColumn("NetKg");
            $table->dropColumn("Feresula");
            $table->dropColumn("VarianceShortage");
            $table->dropColumn("VarianceOverage");
            $table->dropColumn("BagWeight");
        });
    }
}
