<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FiscalyearToPrdOrdersTable extends Migration
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
            $table->string('FiscalYear')->default()->nullable()->after("CurrentDocumentNumber");
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
            $table->dropColumn("FiscalYear");
        });
    }
}
