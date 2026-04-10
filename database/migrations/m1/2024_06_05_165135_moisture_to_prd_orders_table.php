<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MoistureToPrdOrdersTable extends Migration
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
            $table->string('Moisture')->default("")->nullable()->after('ThickCoffee');
            $table->string('WaterActivity')->default("")->nullable()->after('Moisture');
            $table->string('DefectCount')->default("")->nullable()->after('WaterActivity');
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
            $table->dropColumn("Moisture");
            $table->dropColumn("WaterActivity");
            $table->dropColumn("DefectCount");
        });
    }
}
