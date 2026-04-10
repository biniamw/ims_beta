<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditSalesAdditionToCustomersTable extends Migration
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
            $table->string('IsAllowedCreditSales')->default("")->nullable()->after('salesamount');
            $table->integer('CreditSalesLimitStart')->default(0)->nullable()->after('IsAllowedCreditSales');
            $table->integer('CreditSalesLimitEnd')->default(0)->nullable()->after('CreditSalesLimitStart');
            $table->integer('CreditSalesLimitFlag')->default(0)->nullable()->after('CreditSalesLimitEnd');
            $table->integer('CreditSalesLimitDay')->default(0)->nullable()->after('CreditSalesLimitFlag');
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
        Schema::table('customers', function (Blueprint $table) {
            //
            $table->dropColumn('IsAllowedCreditSales');
            $table->dropColumn('CreditSalesLimitStart');
            $table->dropColumn('CreditSalesLimitEnd');
            $table->dropColumn('CreditSalesLimitFlag');
            $table->dropColumn('CreditSalesLimitDay');
            $table->dropColumn('CreditSalesAdditionPercentage');
            $table->dropColumn('SettleAllOutstanding');
        });
    }
}
