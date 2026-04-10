<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimesettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtimesettings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('overtime_id')->default(1)->constrained();
            $table->integer('daynum')->default(0)->nullable();
            $table->string('StartTime')->default("")->nullable();
            $table->string('EndTime')->default("")->nullable();
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
        Schema::dropIfExists('overtimesettings');
    }
}
