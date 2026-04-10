<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductionToTransactionsTable extends Migration
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
            $table->string('ProductionNumber')->default("")->nullable()->after('CertNumber');
            $table->double('VarianceShortage')->default("0")->nullable()->after('GrandTotalPriceComm');
            $table->double('VarianceOverage')->default("0")->nullable()->after('VarianceShortage');
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
            $table->dropColumn("ProductionNumber");
            $table->dropColumn("VarianceShortage");
            $table->dropColumn("VarianceOverage");
        });
    }
}
