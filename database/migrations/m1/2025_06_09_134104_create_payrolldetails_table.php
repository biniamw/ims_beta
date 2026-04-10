<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrolldetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolldetails', function (Blueprint $table) {
            $table->id();
            $table->integer('payrolls_id')->nullable()->default(0);
            $table->integer('employees_id')->nullable()->default(0);
            $table->double('working_day')->nullable()->default(0);
            $table->double('suppose_to_work_hr')->nullable()->default(0);
            $table->double('actual_work_hr')->nullable()->default(0);
            $table->double('per_hr_salary')->nullable()->default(0);
            $table->double('lateabsent_hr')->nullable()->default(0);
            $table->double('total_earning')->nullable()->default(0);
            $table->double('non_taxable_earning')->nullable()->default(0);
            $table->double('taxable_earning')->nullable()->default(0);
            $table->double('total_deduction')->nullable()->default(0);
            $table->double('net_pay')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payrolldetails');
    }
}
