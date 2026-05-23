<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_order_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('delivery_order_id')->nullable()->default(0);
            $table->foreignId('regitems_id')->constrained();
            $table->double('quantity')->nullable()->default(0);
            $table->double('unit_price')->nullable()->default(0);
            $table->double('total_price')->nullable()->default(0);
            $table->double('factor')->nullable()->default(0);
            $table->double('quantity_pcs')->nullable()->default(0);
            $table->double('standard_kg')->nullable()->default(0);
            $table->double('price_per_kg')->nullable()->default(0);
            $table->double('std_total_price')->nullable()->default(0);
            $table->bigInteger('new_uom')->nullable()->default(0);
            $table->bigInteger('default_uom')->nullable()->default(0);
            $table->double('converted_quantity')->nullable()->default(0);
            $table->integer('entered_qty')->nullable()->default(0);
            $table->integer('entered_serial_qty')->nullable()->default(0);
            $table->integer('is_fully_entered')->nullable()->default(0);
            $table->bigInteger('reference_detail_id')->nullable()->default(0);
            $table->string('remark')->nullable()->default("");
            $table->string('std_remark')->nullable()->default("");
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
        Schema::dropIfExists('delivery_order_details');
    }
}
