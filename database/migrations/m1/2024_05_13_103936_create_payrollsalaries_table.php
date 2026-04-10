<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrollsalaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payrolls_id')->constrained();
            $table->foreignId('employees_id')->constrained();
            $table->foreignId('salarytypes_id')->constrained();
            $table->double('Earning')->default(0)->nullable();
            $table->double('Deduction')->default(0)->nullable();
            $table->double('Others')->default(0)->nullable();
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
        Schema::dropIfExists('payrollsalaries');
    }
}
