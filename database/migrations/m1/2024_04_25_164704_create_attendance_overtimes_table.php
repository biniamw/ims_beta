<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_overtimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employees_id')->default(1)->constrained();
            $table->foreignId('overtime_id')->default(1)->constrained();
            $table->integer('daynum')->default(0)->nullable();
            $table->string('Date')->default("")->nullable();
            $table->string('OtStartTime')->default("")->nullable();
            $table->string('OtEndTime')->default("")->nullable();
            $table->double('OtDurationMin')->default(0)->nullable();
            $table->double('Rate')->default(0)->nullable();
            $table->integer('IsPayrollClosed')->default(0)->nullable();
            $table->integer('Type')->default(0)->nullable();
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
        Schema::dropIfExists('attendance_overtimes');
    }
}
