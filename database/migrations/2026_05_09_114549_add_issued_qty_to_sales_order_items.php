<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIssuedQtyToSalesOrderItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales_order_items', function (Blueprint $table) {
            //
            $table->integer('issued_qty')->nullable()->after('dprice')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales_order_items', function (Blueprint $table) {
            //
            $table->dropColumn("issued_qty");
        });
    }
}
