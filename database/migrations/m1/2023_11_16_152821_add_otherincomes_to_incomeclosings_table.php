<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherincomesToIncomeclosingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incomeclosings', function (Blueprint $table) {
            //
            $table->double('CreditFiscalOtherIncome')->nullable()->default(0)->after('OtherIncome');
            $table->double('CashManualOtherIncome')->nullable()->default(0)->after('CreditFiscalOtherIncome');
            $table->double('CreditManualOtherIncome')->nullable()->default(0)->after('CashManualOtherIncome');
            $table->double('FisCashIncome')->nullable()->default(0)->after('CreditManualOtherIncome');
            $table->double('FisCreditIncome')->nullable()->default(0)->after('FisCashIncome');
            $table->double('ManCashIncome')->nullable()->default(0)->after('FisCreditIncome');
            $table->double('ManCreditIncome')->nullable()->default(0)->after('ManCashIncome');
            $table->double('CreditSettIncome')->nullable()->default(0)->after('ManCreditIncome');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incomeclosings', function (Blueprint $table) {
            //
            $table->dropColumn('CreditFiscalOtherIncome');
            $table->dropColumn('CashManualOtherIncome');
            $table->dropColumn('CreditManualOtherIncome');
            $table->dropColumn('FisCashIncome');
            $table->dropColumn('FisCreditIncome');
            $table->dropColumn('ManCashIncome');
            $table->dropColumn('ManCreditIncome');
            $table->dropColumn('CreditSettIncome');
        });
    }
}
