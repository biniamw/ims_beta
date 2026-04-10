<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpLeaveallocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_leaveallocs', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id')->default(0)->nullable();
            $table->string('LeaveAllocationNo')->default("")->nullable();
            $table->string('Type')->default("")->nullable();
            $table->string('Date')->default("")->nullable();
            $table->string('Memo')->default("")->nullable();
            $table->string('Status')->default("")->nullable();
            $table->string('OldStatus')->default("")->nullable();
            $table->integer('AllocationNo')->default(0)->nullable();
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
        Schema::dropIfExists('emp_leaveallocs');
    }
}
