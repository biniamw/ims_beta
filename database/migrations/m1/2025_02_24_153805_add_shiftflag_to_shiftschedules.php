<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShiftflagToShiftschedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shiftschedules', function (Blueprint $table) {
            //
            $table->string('ShiftFlag')->default(1)->nullable()->after('EffectiveOt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shiftschedules', function (Blueprint $table) {
            //
            $table->dropColumn("ShiftFlag");
        });
    }
}
