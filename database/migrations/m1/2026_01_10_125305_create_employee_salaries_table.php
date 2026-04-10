<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_salaries', function (Blueprint $table) {
            $table->id();
            $table->string('doc_number')->nullable()->default("");
            $table->integer('employees_id')->nullable()->default(0);
            $table->integer('is_negotiable')->nullable()->default(0);
            $table->integer('salaries_id')->nullable()->default(0);
            $table->string('doc_name')->nullable()->default("");
            $table->string('actual_file_name')->nullable()->default("");
            $table->string('date')->nullable()->default("");
            $table->string('remark')->nullable()->default("");
            $table->string('status')->nullable()->default("");
            $table->string('old_status')->nullable()->default("");
            $table->integer('inc_value')->nullable()->default(0);
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
        Schema::dropIfExists('employee_salaries');
    }
}
