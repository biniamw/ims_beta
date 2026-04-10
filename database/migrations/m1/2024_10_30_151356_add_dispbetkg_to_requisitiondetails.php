<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDispbetkgToRequisitiondetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisitiondetails', function (Blueprint $table) {
            //
            $table->double('DispNumOfBag')->default(0)->nullable()->after('ExportCertNumber');
            $table->double('DispNetKg')->default(0)->nullable()->after('DispNumOfBag');
            $table->double('DispFeresula')->default(0)->nullable()->after('DispNetKg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisitiondetails', function (Blueprint $table) {
            //
            $table->dropColumn("DispNumOfBag");
            $table->dropColumn("DispNetKg");
            $table->dropColumn("DispFeresula");
        });
    }
}
