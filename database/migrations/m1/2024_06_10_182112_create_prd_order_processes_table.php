<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrdOrderProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prd_order_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prd_orders_id')->constrained();
            $table->foreignId('prd_order_details_id')->constrained();
            $table->string('Date')->default("")->nullable();
            $table->string('LocationId')->default("")->nullable();
            $table->foreignId('uoms_id')->constrained();
            $table->double('QuantityByUom')->default(0)->nullable();
            $table->double('QuantityByKg')->default(0)->nullable();
            $table->string("Remark","65535")->nullable();
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
        Schema::dropIfExists('prd_order_processes');
    }
}
