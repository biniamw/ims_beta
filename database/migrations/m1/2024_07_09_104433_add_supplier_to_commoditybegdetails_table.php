<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSupplierToCommoditybegdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commoditybegdetails', function (Blueprint $table) {
            //
            $table->string('SupplierId')->default("")->nullable()->after('customers_id');
            $table->string('GrnNumber')->default("")->nullable()->after('SupplierId');
            $table->string('CertNumber')->default("")->nullable()->after('GrnNumber');
            $table->double('NumOfBag')->default("0")->nullable()->after('uoms_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commoditybegdetails', function (Blueprint $table) {
            //
            $table->dropColumn("SupplierId");
            $table->dropColumn("GrnNumber");
            $table->dropColumn("CertNumber");
            $table->dropColumn("NumOfBag");
        });
    }
}
