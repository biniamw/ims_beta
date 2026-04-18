<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddItemuuidToReceivingdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receivingdetails', function (Blueprint $table) {
            //
            $table->string('item_uuid')->nullable()->after('Common')->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receivingdetails', function (Blueprint $table) {
            //
            $table->dropColumn("item_uuid");
        });
    }
}
