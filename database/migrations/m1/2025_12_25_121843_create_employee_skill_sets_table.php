<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSkillSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_skill_sets', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id')->nullable()->default(0);
            $table->integer('skills_id')->nullable()->default(0);
            $table->integer('level_id')->nullable()->default(0);
            $table->string('remark')->nullable()->default("");
            $table->integer('type')->nullable()->default(0);
            $table->string('description')->nullable()->default("");
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
        Schema::dropIfExists('employee_skill_sets');
    }
}
