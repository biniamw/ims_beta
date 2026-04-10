<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrdDurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prd_durations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prd_orders_id')->constrained();
            $table->string('StartTime')->default("")->nullable();
            $table->string('EndTime')->default("")->nullable();
            $table->string('Duration')->default("")->nullable();
            $table->string('StartedBy')->default("")->nullable();
            $table->string('PausedBy')->default("")->nullable();
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
        Schema::dropIfExists('prd_durations');
    }
}
