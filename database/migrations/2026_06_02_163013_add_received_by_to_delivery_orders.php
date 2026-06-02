<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReceivedByToDeliveryOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('delivery_orders', function (Blueprint $table) {
            //
            $table->string('received_by')->nullable()->default("")->after('delivery_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('delivery_orders', function (Blueprint $table) {
            //
            $table->dropColumn("received_by");
        });
    }
}
