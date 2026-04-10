<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomeridToCommoditybegsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commoditybegs', function (Blueprint $table) {
            //
            $table->foreignId('customers_id')->default(1)->constrained()->after('stores_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commoditybegs', function (Blueprint $table) {
            //
            $table->dropColumn("customers_id");
        });
    }
}
