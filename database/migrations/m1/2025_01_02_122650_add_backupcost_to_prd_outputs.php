<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBackupcostToPrdOutputs extends Migration
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
            $table->double('UnitCostCommBackup')->default(0)->nullable()->after('Inspection');
            $table->double('BeforeTaxCostBackup')->default(0)->nullable()->after('UnitCostCommBackup');
            $table->double('TaxCostCommBackup')->default(0)->nullable()->after('BeforeTaxCostBackup');
            $table->double('GrandTotalCostCommBackup')->default(0)->nullable()->after('TaxCostCommBackup');
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
            $table->dropColumn("UnitCostCommBackup");
            $table->dropColumn("BeforeTaxCostBackup");
            $table->dropColumn("TaxCostCommBackup");
            $table->dropColumn("GrandTotalCostCommBackup");
        });
    }
}
