<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnteredSerialQtyToReceivingdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receivingdetails', function (Blueprint $table) {
            //
            $table->integer('entered_serial_qty')->nullable()->after('entered_qty')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receivingdetails', function (Blueprint $table) {
            //
            $table->dropColumn("entered_serial_qty");
        });
    }
}
