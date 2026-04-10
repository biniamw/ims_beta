<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrollsettings', function (Blueprint $table) {
            $table->id();
            $table->double('MinAmount')->default(0)->nullable();
            $table->double('MaxAmount')->default(0)->nullable();
            $table->double('TaxRate')->default(0)->nullable();
            $table->double('Deduction')->default(0)->nullable();
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
        Schema::dropIfExists('payrollsettings');
    }
}
