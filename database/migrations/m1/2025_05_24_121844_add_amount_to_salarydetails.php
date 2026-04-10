<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountToSalarydetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salarydetails', function (Blueprint $table) {
            //
            $table->double('Amount')->nullable()->default(0)->after('salarytypes_id');
            $table->double('NonTaxableAmount')->nullable()->default(0)->after('Amount');
            $table->double('TotalAmount')->nullable()->default(0)->after('NonTaxableAmount');
            $table->double('TaxPercent')->nullable()->default(0)->after('TotalAmount');
            $table->double('Deduction')->nullable()->default(0)->after('TaxPercent');
            $table->integer('Type')->nullable()->default(0)->after('Deduction');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salarydetails', function (Blueprint $table) {
            //
            $table->dropColumn("Amount");
            $table->dropColumn("NonTaxableAmount");
            $table->dropColumn("TotalAmount");
            $table->dropColumn("TaxPercent");
            $table->dropColumn("Deduction");
            $table->dropColumn("Type");
        });
    }
}
