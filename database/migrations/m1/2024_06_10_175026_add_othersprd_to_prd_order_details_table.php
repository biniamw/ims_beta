<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOthersprdToPrdOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prd_order_details', function (Blueprint $table) {
            //
            $table->double('MoisturePercent')->default(0)->nullable()->after('Remark');
            $table->double('PrdWeightByKg')->default(0)->nullable()->after('MoisturePercent');
            $table->double('PrdNumofBag')->default(0)->nullable()->after('PrdWeightByKg');
            $table->double('PrdBagByKg')->default(0)->nullable()->after('PrdNumofBag');
            $table->double('PrdAdjustment')->default(0)->nullable()->after('PrdBagByKg');
            $table->double('PrdNetWeight')->default(0)->nullable()->after('PrdAdjustment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prd_order_details', function (Blueprint $table) {
            //
            $table->dropColumn("MoisturePercent");
            $table->dropColumn("PrdWeightByKg");
            $table->dropColumn("PrdNumofBag");
            $table->dropColumn("PrdBagByKg");
            $table->dropColumn("PrdAdjustment");
            $table->dropColumn("PrdNetWeight");
        });
    }
}
