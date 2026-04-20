<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsFullyEnteredToReceivingdetails extends Migration
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
            $table->integer('is_fully_entered')->nullable()->after('Common')->default(0);
            $table->integer('entered_qty')->nullable()->after('is_fully_entered')->default(0);
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
            $table->dropColumn("is_fully_entered");
            $table->dropColumn("entered_qty");
        });
    }
}
