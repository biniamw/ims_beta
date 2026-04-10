<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationidToPrdOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prd_order_details', function (Blueprint $table) {
            //
            $table->string('LocationId')->default("")->nullable()->after('stores_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prd_order_details', function (Blueprint $table) {
            //
            $table->dropColumn("LocationId");
        });
    }
}
