<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductionToCommoditybegdetailsTable extends Migration
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
            $table->string('ProductionNumber')->default("")->nullable()->after('CertNumber');
            $table->double('VarianceShortage')->default("0")->nullable()->after('TotalPrice');
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
        Schema::table('commoditybegdetails', function (Blueprint $table) {
            //
            $table->dropColumn("ProductionNumber");
            $table->dropColumn("VarianceShortage");
            $table->dropColumn("VarianceOverage");
        });
    }
}
