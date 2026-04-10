<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrdBomdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prd_bomdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prd_boms_id')->constrained();
            $table->foreignId('woredas_id')->constrained();
            $table->string("Grade",)->nullable();
            $table->string("ProcessType",)->nullable();
            $table->string("CropYear",)->nullable();
            $table->foreignId('uoms_id')->constrained();
            $table->double('Quantity')->default(0)->nullable();
            $table->double('UnitCost')->default(0)->nullable();
            $table->double('TotalCost')->default(0)->nullable();
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
        Schema::dropIfExists('prd_bomdetails');
    }
}
