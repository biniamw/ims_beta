<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNetkgToPrdOutputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prd_outputs', function (Blueprint $table) {
            //
            $table->string('CleanProductType')->default("")->nullable()->after('CertificationId');
            $table->double('BagWeight')->default(0)->nullable()->after('FullWeightbyKg');
            $table->double('NetKg')->default(0)->nullable()->after('BagWeight');
            $table->double('Feresula')->default(0)->nullable()->after('NetKg');
            $table->double('VarianceShortage')->default(0)->nullable()->after('Feresula');
            $table->double('VarianceOverage')->default(0)->nullable()->after('VarianceShortage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prd_outputs', function (Blueprint $table) {
            //
            $table->dropColumn("CleanProductType");
            $table->dropColumn("BagWeight");
            $table->dropColumn("NetKg");
            $table->dropColumn("Feresula");
            $table->dropColumn("VarianceShortage");
            $table->dropColumn("VarianceOverage");
        });
    }
}
