<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRatiovarianceToPrdOrderDetailsTable extends Migration
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
            $table->double('RatioVarianceShortage')->default("0")->nullable()->after('PrdNetWeight');
            $table->double('RatioVarianceOverage')->default("0")->nullable()->after('RatioVarianceShortage');
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
            $table->dropColumn("RatioVarianceShortage");
            $table->dropColumn("RatioVarianceOverage");
        });
    }
}
