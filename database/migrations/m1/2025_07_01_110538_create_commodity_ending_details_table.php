<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommodityEndingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commodity_ending_details', function (Blueprint $table) {
            $table->id();
            $table->integer('commodity_endings_id')->nullable();
            $table->integer('supplier_id')->nullable();
            $table->string("grn_number")->nullable();
            $table->string("cert_number")->nullable();
            $table->string("production_number")->nullable();
            $table->integer('stores_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->integer('woredas_id')->nullable();
            $table->string("commodity_type")->nullable();
            $table->string("grade")->nullable();
            $table->string("process_type")->nullable();
            $table->string("crop_year")->nullable();
            $table->integer('uoms_id')->nullable();
            $table->double('no_of_bag')->default(0)->nullable();
            $table->double('bag_weight')->default(0)->nullable();
            $table->double('total_kg')->default(0)->nullable();
            $table->double('net_kg')->default(0)->nullable();
            $table->double('feresula')->default(0)->nullable();
            $table->double('unit_cost')->default(0)->nullable();
            $table->double('total_cost')->default(0)->nullable();
            $table->double('variance_shortage')->default(0)->nullable();
            $table->double('variance_overage')->default(0)->nullable();
            $table->double('disc_shortage_kg')->default(0)->nullable();
            $table->double('disc_overage_kg')->default(0)->nullable();
            $table->double('disc_shortage_bag')->default(0)->nullable();
            $table->double('disc_overage_bag')->default(0)->nullable();
            $table->string("remark","65535")->nullable();
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
        Schema::dropIfExists('commodity_ending_details');
    }
}
