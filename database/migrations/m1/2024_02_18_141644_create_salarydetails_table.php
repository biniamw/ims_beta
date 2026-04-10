<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarydetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salarydetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salaries_id')->constrained();
            $table->foreignId('salarytypes_id')->constrained();
            $table->double('EarningAmount')->nullable()->default(0);
            $table->double('DeductionAmount')->nullable()->default(0);
            $table->string('Remark')->default("")->nullable();
            $table->string('Status')->default("")->nullable();
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
        Schema::dropIfExists('salarydetails');
    }
}
