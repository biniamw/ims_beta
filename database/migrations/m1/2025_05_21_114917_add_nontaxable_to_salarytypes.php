<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNontaxableToSalarytypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salarytypes', function (Blueprint $table) {
            //
            $table->double('NonTaxableAmount')->nullable()->default(0)->after('SalaryType');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salarytypes', function (Blueprint $table) {
            //
            $table->dropColumn("NonTaxableAmount");
        });
    }
}
