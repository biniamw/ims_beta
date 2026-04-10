<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollemployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrollemployees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payrolls_id')->constrained();
            $table->foreignId('employees_id')->constrained();
            $table->double('WorkingDays')->default(0)->nullable();
            $table->double('BasicSalary')->default(0)->nullable();
            $table->double('OtherEarning')->default(0)->nullable();
            $table->double('TotalEarning')->default(0)->nullable();
            $table->double('TaxableEarning')->default(0)->nullable();
            $table->double('IncomeTax')->default(0)->nullable();
            $table->double('Pension')->default(0)->nullable();
            $table->double('ComPension')->default(0)->nullable();
            $table->double('OtherDeduction')->default(0)->nullable();
            $table->double('TotalDeduction')->default(0)->nullable();
            $table->double('NetPay')->default(0)->nullable();
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
        Schema::dropIfExists('payrollemployees');
    }
}
