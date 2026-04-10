<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupplierToPrdOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prd_order_details', function (Blueprint $table) {
            //
            $table->string('SupplierId')->default("")->nullable()->after('Symbol');
            $table->string('GrnNumber')->default("")->nullable()->after('SupplierId');
            $table->string('CertNumber')->default("")->nullable()->after('GrnNumber');
            $table->double('UnitCost')->default("0")->nullable()->after('QuantityInKG');
            $table->double('TotalCost')->default("0")->nullable()->after('UnitCost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prd_order_details', function (Blueprint $table) {
            //
            $table->dropColumn("SupplierId");
            $table->dropColumn("GrnNumber");
            $table->dropColumn("CertNumber");
            $table->dropColumn("UnitCost");
            $table->dropColumn("TotalCost");
        });
    }
}
