<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQtyonhandflgToStores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            //
            $table->integer('QtyOnHandFlag')->default(0)->nullable()->after('IncomeClosingDate');
            $table->integer('CheckQtyOnHand')->default(0)->nullable()->after('QtyOnHandFlag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            //
            $table->dropColumn("QtyOnHandFlag");
            $table->dropColumn("CheckQtyOnHand");
        });
    }
}
