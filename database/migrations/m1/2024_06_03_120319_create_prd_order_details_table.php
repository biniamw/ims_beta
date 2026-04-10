<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrdOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prd_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prd_orders_id')->constrained();
            $table->string("CommodityType")->nullable();
            $table->foreignId('woredas_id')->constrained();
            $table->string("Grade",)->nullable();
            $table->string("ProcessType")->nullable();
            $table->string("CropYear")->nullable();
            $table->string("Symbol")->nullable();
            $table->foreignId('stores_id')->constrained();
            $table->foreignId('uoms_id')->constrained();
            $table->double('Quantity')->default(0)->nullable();
            $table->double('QuantityInKG')->default(0)->nullable();
            $table->double('UomFactor')->default(0)->nullable();
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
        Schema::dropIfExists('prd_order_details');
    }
}
