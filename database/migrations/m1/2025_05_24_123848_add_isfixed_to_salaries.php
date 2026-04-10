<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsfixedToSalaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salaries', function (Blueprint $table) {
            //
            $table->double('TaxableEarning')->nullable()->default(0)->after('TotalEarnings');
            $table->double('NonTaxableEarning')->nullable()->default(0)->after('TaxableEarning');
            $table->double('CompanyPension')->nullable()->default(0)->after('NonTaxableEarning');
            $table->integer('IsFixed')->nullable()->default(0)->after('UpdateSalaryFlag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salaries', function (Blueprint $table) {
            //
            $table->dropColumn("TaxableEarning");
            $table->dropColumn("NonTaxableEarning");
            $table->dropColumn("CompanyPension");
            $table->dropColumn("IsFixed");
        });
    }
}
