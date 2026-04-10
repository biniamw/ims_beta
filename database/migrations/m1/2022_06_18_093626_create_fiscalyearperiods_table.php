<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiscalyearperiodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiscalyearperiods', function (Blueprint $table) {
            $table->id();
            $table->integer('header_id')->default(0);
            $table->string('PeriodName')->nullable();
            $table->string('PeriodStartDate')->nullable();
            $table->string('PeriodEndDate')->nullable();
            $table->string('Order')->nullable();
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
        Schema::dropIfExists('fiscalyearperiods');
    }
}
