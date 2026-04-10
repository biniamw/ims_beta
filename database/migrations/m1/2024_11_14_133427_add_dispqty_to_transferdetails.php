<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDispqtyToTransferdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transferdetails', function (Blueprint $table) {
            //
            $table->double('DispatchQuantity')->default(0)->nullable()->after('IssuedQuantity');
            $table->double('ReceivedQuantity')->default(0)->nullable()->after('DispatchQuantity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transferdetails', function (Blueprint $table) {
            //
            $table->dropColumn("DispatchQuantity");
            $table->dropColumn("ReceivedQuantity");
        });
    }
}
