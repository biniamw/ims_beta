<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrEmployeeLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_employee_leaves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employees_id')->constrained();
            $table->foreignId('hr_leavetypes_id')->constrained();
            $table->double('LeaveBalance')->nullable();
            $table->string('IsAllowed')->nullable();
            $table->integer('DepOnBalance')->nullable()->default(1);
            $table->string('Remark',"65535")->nullable();
            $table->unique(['employees_id','hr_leavetypes_id']);
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
        Schema::dropIfExists('hr_employee_leaves');
    }
}
