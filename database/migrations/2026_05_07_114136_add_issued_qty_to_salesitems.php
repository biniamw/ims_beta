<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIssuedQtyToSalesitems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salesitems', function (Blueprint $table) {
            //
            $table->integer('issued_qty')->nullable()->after('dispatched_qty')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salesitems', function (Blueprint $table) {
            //
            $table->dropColumn("issued_qty");
        });
    }
}
