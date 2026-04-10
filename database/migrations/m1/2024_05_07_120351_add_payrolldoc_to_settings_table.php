<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPayrolldocToSettingsTable extends Migration
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
            $table->string('PayrollAddPrefix')->nullable()->after('PayrollCalendarType');
            $table->integer('PayrollAddNumber')->default(0)->nullable()->after('PayrollAddPrefix');
            $table->string('PayrollPrefix')->nullable()->after('PayrollAddNumber');
            $table->integer('PayrollNumber')->default(0)->nullable()->after('PayrollPrefix');
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
            $table->dropColumn('PayrollAddPrefix');
            $table->dropColumn('PayrollAddNumber');
            $table->dropColumn('PayrollPrefix');
            $table->dropColumn('PayrollNumber');
        });
    }
}
