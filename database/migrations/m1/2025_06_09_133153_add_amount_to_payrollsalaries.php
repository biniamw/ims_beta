<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAmountToPayrollsalaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payrollsalaries', function (Blueprint $table) {
            //
            $table->integer('overtimes_id')->nullable()->default(0)->after('salarytypes_id');
            $table->double('earning_amount')->nullable()->default(0)->after('overtimes_id');
            $table->double('non_taxable')->nullable()->default(0)->after('earning_amount');
            $table->double('deduction_amount')->nullable()->default(0)->after('non_taxable');
            $table->integer('salarytype_src')->nullable()->default(0)->after('deduction_amount');
            $table->integer('payrolladditions_id')->nullable()->default(0)->after('salarytype_src');
            $table->double('percent')->nullable()->default(0)->after('payrolladditions_id');
            $table->double('tax_deduction')->nullable()->default(0)->after('percent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payrollsalaries', function (Blueprint $table) {
            //
            $table->dropColumn("overtimes_id");
            $table->dropColumn("amount");
            $table->dropColumn("non_taxable");
            $table->dropColumn("deduction_amount");
            $table->dropColumn("salarytype_src");
            $table->dropColumn("payrolladditions_id");
            $table->dropColumn("percent");
            $table->dropColumn("tax_deduction");
        });
    }
}
