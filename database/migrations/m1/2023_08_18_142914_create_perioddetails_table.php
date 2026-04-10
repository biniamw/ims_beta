<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerioddetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perioddetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periods_id')->constrained();
            $table->foreignId('days_id')->constrained();
            $table->string('Days')->nullable()->default("");
            $table->string('FirstHalfFrom')->nullable()->default("");
            $table->string('FirstHalfTo')->nullable()->default("");
            $table->string('SecondHalfFrom')->nullable()->default("");
            $table->string('SecondHalfTo')->nullable()->default("");
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
        Schema::dropIfExists('perioddetails');
    }
}
