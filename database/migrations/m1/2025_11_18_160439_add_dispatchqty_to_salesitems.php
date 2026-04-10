<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDispatchqtyToSalesitems extends Migration
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
            $table->double('dispatched_qty')->nullable()->default(0)->after('wholesaleflag');
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
            $table->dropColumn("dispatched_qty");
        });
    }
}
