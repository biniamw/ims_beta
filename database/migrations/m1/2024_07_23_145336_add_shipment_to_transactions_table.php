<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShipmentToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
            $table->double('ShipmentQuantityFeresula')->default("0")->nullable()->after('ShipmentQuantity');
            $table->double('ShipmentQuantityNumofBag')->default("0")->nullable()->after('ShipmentQuantityFeresula');
            $table->string('SourceStore')->default("")->nullable()->after('VarianceOverage');
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
            $table->dropColumn("ShipmentQuantityFeresula");
            $table->dropColumn("ShipmentQuantityNumofBag");
            $table->dropColumn("SourceStore");
        });
    }
}
