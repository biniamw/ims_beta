<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMinimumperiodToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->double('MinimumPeriod')->nullable()->default(0)->after('SettleAllOutstanding');
            $table->double('PurchaseLimit')->nullable()->default(0)->after('MinimumPeriod');
            $table->double('MinimumPurchaseAmount')->nullable()->default(0)->after('PurchaseLimit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->dropColumn('MinimumPeriod');
            $table->dropColumn('PurchaseLimit');
            $table->dropColumn('MinimumPurchaseAmount');
        });
    }
}
