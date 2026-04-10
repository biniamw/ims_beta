<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shiftdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shifts_id')->constrained();
            $table->foreignId('days_id')->constrained();
            $table->string('Days')->nullable()->default("");
            $table->string('BlEarlyStartTime')->nullable()->default("");
            $table->string('BlStartTime')->nullable()->default("");
            $table->string('BlLateStartTime')->nullable()->default("");
            $table->string('BlEarlyEndTime')->nullable()->default("");
            $table->string('BlEndTime')->nullable()->default("");
            $table->string('BlLateEndTime')->nullable()->default("");
            $table->string('AlEarlyStartTime')->nullable()->default("");
            $table->string('AlStartTime')->nullable()->default("");
            $table->string('AlLateStartTime')->nullable()->default("");
            $table->string('AlEarlyEndTime')->nullable()->default("");
            $table->string('AlEndTime')->nullable()->default("");
            $table->string('AlLateEndTime')->nullable()->default("");
            $table->string('Remark')->nullable()->default("");
            $table->string('Status')->nullable()->default("");
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
        Schema::dropIfExists('shiftdetails');
    }
}
