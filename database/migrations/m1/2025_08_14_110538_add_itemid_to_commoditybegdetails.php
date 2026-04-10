<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemidToCommoditybegdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commoditybegdetails', function (Blueprint $table) {
            //
            $table->biginteger('item_id')->nullable()->default(0)->after('ArrivalDate');
            $table->double('quantity')->nullable()->default(0)->after('item_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commoditybegdetails', function (Blueprint $table) {
            //
            $table->dropColumn("item_id");
            $table->dropColumn("quantity");
        });
    }
}
