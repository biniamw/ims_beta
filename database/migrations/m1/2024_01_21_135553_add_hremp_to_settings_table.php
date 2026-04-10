<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHrempToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->string('HrEmployeePrefix')->nullable()->after('IncomeNumber');
            $table->integer('HrEmployeeNumber')->nullable()->default(0)->after('HrEmployeePrefix');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->dropColumn('HrEmployeePrefix');
            $table->dropColumn('HrEmployeeNumber');
        });
    }
}
