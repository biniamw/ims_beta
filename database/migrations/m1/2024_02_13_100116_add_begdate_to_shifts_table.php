<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBegdateToShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shifts', function (Blueprint $table) {
            //
            $table->string('BegininngDate')->nullable()->after("ShiftName");
            $table->integer('CycleNumber')->nullable()->default(0)->after("BegininngDate");
            $table->integer('CycleUnit')->nullable()->default(0)->after("CycleNumber");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shifts', function (Blueprint $table) {
            //
            $table->dropColumn('BegininngDate');
            $table->dropColumn('CycleNumber');
            $table->dropColumn('CycleUnit');
        });
    }
}
