<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBalanceToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('woredaId')->default(0)->nullable();
            $table->integer('uomId')->default(0)->nullable();
            $table->string("CommodityType",)->nullable();
            $table->string("Grade",)->nullable();
            $table->string("ProcessType",)->nullable();
            $table->string("CropYear",)->nullable();
            $table->double('StockInComm')->default(0)->nullable();
            $table->double('StockInFeresula')->default(0)->nullable();
            $table->double('UnitCostComm')->default(0)->nullable();
            $table->double('TotalCostComm')->default(0)->nullable();
            $table->double('TaxCostComm')->default(0)->nullable();
            $table->double('GrandTotalCostComm')->default(0)->nullable();
            $table->double('StockOutComm')->default(0)->nullable();
            $table->double('StockOutFeresula')->default(0)->nullable();
            $table->double('UnitPriceComm')->default(0)->nullable();
            $table->double('TotalPriceComm')->default(0)->nullable();
            $table->double('TaxPriceComm')->default(0)->nullable();
            $table->double('GrandTotalPriceComm')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
            $table->dropColumn("woredaId");
            $table->dropColumn("uomId");
            $table->dropColumn("CommodityType",)->nullable();
            $table->dropColumn("Grade",)->nullable();
            $table->dropColumn("ProcessType",)->nullable();
            $table->dropColumn("CropYear",)->nullable();
            $table->dropColumn("StockInComm");
            $table->dropColumn("StockInFeresula");
            $table->dropColumn("UnitCostComm");
            $table->dropColumn("TotalCostComm");
            $table->dropColumn("TaxCostComm");
            $table->dropColumn("GrandTotalCostComm");
            $table->dropColumn("StockOutComm");
            $table->dropColumn("StockOutFeresula");
            $table->dropColumn("UnitPriceComm");
            $table->dropColumn("TaxPriceComm");
            $table->dropColumn("TotalPriceComm");
            $table->dropColumn("GrandTotalPriceComm");
        });
    }
}
