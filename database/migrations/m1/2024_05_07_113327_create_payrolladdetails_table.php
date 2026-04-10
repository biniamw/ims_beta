<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrolladdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolladdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payrolladditions_id')->constrained();
            $table->foreignId('employees_id')->constrained();
            $table->foreignId('salarytypes_id')->constrained();
            $table->double('Amount')->default(0)->nullable();
            $table->string('Remark')->nullable();
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
        Schema::dropIfExists('payrolladdetails');
    }
}
