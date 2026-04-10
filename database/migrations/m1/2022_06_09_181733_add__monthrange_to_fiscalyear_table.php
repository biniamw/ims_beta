<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMonthrangeToFiscalyearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fiscalyear', function (Blueprint $table) {
            //
            $table->string('Monthrange')->nullable()->after('FiscalYear');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fiscalyear', function (Blueprint $table) {
            //
            $table->dropColumn('Monthrange');
        });
    }
}
