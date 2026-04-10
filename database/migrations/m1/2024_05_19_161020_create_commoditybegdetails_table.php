<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommoditybegdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commoditybegdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commoditybegs_id')->constrained();
            $table->foreignId('stores_id')->constrained();
            $table->foreignId('woredas_id')->constrained();
            $table->string("CommodityType",)->nullable();
            $table->string("Grade",)->nullable();
            $table->string("ProcessType",)->nullable();
            $table->string("CropYear",)->nullable();
            $table->foreignId('uoms_id')->constrained();
            $table->double('Balance')->default(0)->nullable();
            $table->double('Feresula')->default(0)->nullable();
            $table->double('UnitPrice')->default(0)->nullable();
            $table->double('TotalPrice')->default(0)->nullable();
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
        Schema::dropIfExists('commoditybegdetails');
    }
}
