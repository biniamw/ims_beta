<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsDisplayedToFiscalyearperiodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiscalyearperiods', function (Blueprint $table) {
            //
            $table->string('IsDisplayed')->default(0)->nullable()->after('Order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fiscalyearperiods', function (Blueprint $table) {
            //
            $table->dropColumn('IsDisplayed');
        });
    }
}
