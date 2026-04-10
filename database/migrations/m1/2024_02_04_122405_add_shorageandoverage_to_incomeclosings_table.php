<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShorageandoverageToIncomeclosingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incomeclosings', function (Blueprint $table) {
            //
            $table->double('ShortageAmount')->nullable()->default(0)->after("TotalZAmount");
            $table->double('OverageAmount')->nullable()->default(0)->after("ShortageAmount");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incomeclosings', function (Blueprint $table) {
            //
            $table->dropColumn('ShortageAmount');
            $table->dropColumn('OverageAmount');
        });
    }
}
