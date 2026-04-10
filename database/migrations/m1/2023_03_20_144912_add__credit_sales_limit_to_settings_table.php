<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreditSalesLimitToSettingsTable extends Migration
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
            $table->integer('CreditSalesLimitStart')->default(0)->nullable()->after('costType');
            $table->integer('CreditSalesLimitEnd')->default(0)->nullable()->after('CreditSalesLimitStart');
            $table->integer('CreditSalesLimitFlag')->default(0)->nullable()->after('CreditSalesLimitEnd');
            $table->integer('CreditSalesLimitDay')->default(0)->nullable()->after('CreditSalesLimitFlag');
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
            $table->dropColumn('CreditSalesLimitStart');
            $table->dropColumn('CreditSalesLimitEnd');
            $table->dropColumn('CreditSalesLimitFlag');
            $table->dropColumn('CreditSalesLimitDay');
        });
    }
}
