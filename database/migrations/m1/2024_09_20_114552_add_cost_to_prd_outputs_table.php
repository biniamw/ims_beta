<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCostToPrdOutputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prd_outputs', function (Blueprint $table) {
            //
            $table->double('UnitCost')->default(0)->nullable()->after('VarianceOverage');
            $table->double('TotalCost')->default(0)->nullable()->after('UnitCost');
            $table->double('TaxCost')->default(0)->nullable()->after('TotalCost');
            $table->double('GrandTotalCost')->default(0)->nullable()->after('TaxCost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prd_outputs', function (Blueprint $table) {
            //
            $table->dropColumn("UnitCost");
            $table->dropColumn("TotalCost");
            $table->dropColumn("TaxCost");
            $table->dropColumn("GrandTotalCost");
        });
    }
}
