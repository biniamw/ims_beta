<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('ShiftName')->default("")->nullable();
            $table->string('Description')->default("")->nullable();
            $table->string('CreatedBy')->default("")->nullable();
            $table->string('LastEditedBy')->default("")->nullable();
            $table->string('LastEditedDate')->default("")->nullable();
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
        Schema::dropIfExists('shifts');
    }
}
