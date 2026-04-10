<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupplierToTransactionsTable extends Migration
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
            $table->string('SupplierId')->default("")->nullable()->after('ArrivalDate');
            $table->string('GrnNumber')->default("")->nullable()->after('SupplierId');
            $table->string('CertNumber')->default("")->nullable()->after('GrnNumber');
            $table->double('StockInNumOfBag')->default("0")->nullable()->after('uomId');
            $table->double('StockOutNumOfBag')->default("0")->nullable()->after('StockInNumOfBag');
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
            $table->dropColumn("SupplierId");
            $table->dropColumn("GrnNumber");
            $table->dropColumn("CertNumber");
            $table->dropColumn("StockInNumOfBag");
            $table->dropColumn("StockOutNumOfBag");
        });
    }
}
