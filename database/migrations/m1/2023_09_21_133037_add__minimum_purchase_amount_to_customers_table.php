<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinimumPurchaseAmountToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            //
            $table->double('MinimumPurchaseAmount')->nullable()->default(0)->after('SettleAllOutstanding');
            $table->double('IsWholesaleBefore')->nullable()->default(0)->after('MinimumPurchaseAmount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            //
            $table->dropColumn('MinimumPurchaseAmount');
            $table->dropColumn('IsWholesaleBefore');
        });
    }
}
