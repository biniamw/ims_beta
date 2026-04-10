<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditSalesAdditionToSettingsTable extends Migration
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
            $table->integer('CreditSalesAdditionPercentage')->default(0)->nullable()->after('CreditSalesLimitDay');
            $table->integer('SettleAllOutstanding')->default(0)->nullable()->after('CreditSalesAdditionPercentage');
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
            $table->dropColumn('CreditSalesAdditionPercentage');
            $table->dropColumn('SettleAllOutstanding');
        });
    }
}
