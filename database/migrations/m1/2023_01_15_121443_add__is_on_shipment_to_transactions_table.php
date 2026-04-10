<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsOnShipmentToTransactionsTable extends Migration
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
            $table->double('IsOnShipment')->default(0)->nullable()->after('IsVoid');
            $table->double('ShipmentQuantity')->default(0)->nullable()->after('IsOnShipment');
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
            $table->dropColumn('IsOnShipment');
            $table->dropColumn('ShipmentQuantity');
        });
    }
}
