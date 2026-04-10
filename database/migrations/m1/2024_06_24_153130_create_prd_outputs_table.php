<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrdOutputsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prd_outputs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prd_orders_id')->constrained();
            $table->string('CertificationId')->default("")->nullable();
            $table->string('BiProductId')->default("")->nullable();
            $table->string('OutputType')->default("")->nullable();
            $table->string('FullUomId')->default("")->nullable();
            $table->double('FullNumofBag')->default(0)->nullable();
            $table->double('FullWeightbyKg')->default(0)->nullable();
            $table->string('PartialUomId')->default("")->nullable();
            $table->double('PartialNumofBag')->default(0)->nullable();
            $table->double('PartialWeightbyKg')->default(0)->nullable();
            $table->double('TotalNumofBag')->default(0)->nullable();
            $table->double('TotalWeightbyKg')->default(0)->nullable();
            $table->string("Inspection","65535")->nullable();
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
        Schema::dropIfExists('prd_outputs');
    }
}
