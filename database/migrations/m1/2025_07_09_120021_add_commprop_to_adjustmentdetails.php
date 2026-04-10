<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommpropToAdjustmentdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adjustmentdetails', function (Blueprint $table) {
            //
            $table->integer('SupplierId')->nullable()->default(0)->after('TransactionType');
            $table->string('GrnNumber')->nullable()->default('')->after('SupplierId');
            $table->string('CertNumber')->nullable()->default('')->after('GrnNumber');
            $table->string('ProductionNumber')->nullable()->default('')->after('CertNumber');
            $table->integer('woredas_id')->nullable()->default(0)->after('ProductionNumber');
            $table->string('CommodityType')->nullable()->default('')->after('woredas_id');
            $table->string('Grade')->nullable()->default('')->after('CommodityType');
            $table->string('ProcessType')->nullable()->default('')->after('Grade');
            $table->string('CropYear')->nullable()->default('')->after('ProcessType');
            $table->integer('uoms_id')->nullable()->nullable()->default(0)->after('CropYear');
            $table->double('NumOfBag')->nullable()->default(0)->after('uoms_id');
            $table->double('BagWeight')->nullable()->default(0)->after('NumOfBag');
            $table->double('TotalKg')->nullable()->default(0)->after('BagWeight');
            $table->double('NetKg')->nullable()->default(0)->after('TotalKg');
            $table->double('Feresula')->nullable()->default(0)->after('NetKg');
            $table->double('unit_cost_or_price')->nullable()->default(0)->after('Feresula');
            $table->double('total_cost_or_price')->nullable()->default(0)->after('unit_cost_or_price');
            $table->double('VarianceShortage')->nullable()->default(0)->after('total_cost_or_price');
            $table->double('VarianceOverage')->nullable()->default(0)->after('VarianceShortage');
            $table->text('Remark')->nullable()->nullable()->after('VarianceOverage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adjustmentdetails', function (Blueprint $table) {
            //
            $table->dropColumn("SupplierId");
            $table->dropColumn("GrnNumber");
            $table->dropColumn("CertNumber");
            $table->dropColumn("ProductionNumber");
            $table->dropColumn("woredas_id");
            $table->dropColumn("CommodityType");
            $table->dropColumn("Grade");
            $table->dropColumn("ProcessType");
            $table->dropColumn("CropYear");
            $table->dropColumn("uoms_id");
            $table->dropColumn("NumOfBag");
            $table->dropColumn("BagWeight");
            $table->dropColumn("TotalKg");
            $table->dropColumn("NetKg");
            $table->dropColumn("Feresula");
            $table->dropColumn("unit_cost_or_price");
            $table->dropColumn("total_cost_or_price");
            $table->dropColumn("VarianceShortage");
            $table->dropColumn("VarianceOverage");
            $table->dropColumn("Remark");
        });
    }
}
