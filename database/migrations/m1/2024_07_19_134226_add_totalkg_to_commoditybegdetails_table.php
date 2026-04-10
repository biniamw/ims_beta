<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTotalkgToCommoditybegdetailsTable extends Migration
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
            $table->double('BagWeight')->default("0")->nullable()->after('NumOfBag');
            $table->double('TotalKg')->default("0")->nullable()->after('BagWeight');
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
            $table->dropColumn("BagWeight");
            $table->dropColumn("TotalKg");
        });
    }
}
