<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVarianceToPrdOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prd_orders', function (Blueprint $table) {
            //
            $table->double('VarianceShortage')->default("0")->nullable()->after('PrdNetWeight');
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
        Schema::table('prd_orders', function (Blueprint $table) {
            //
            $table->dropColumn("VarianceShortage");
            $table->dropColumn("VarianceOverage");
        });
    }
}
