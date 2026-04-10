<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProducttypeToCommoditybegs extends Migration
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
            $table->integer('product_type')->nullable()->default(0)->after('id');
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
            $table->dropColumn("product_type");
        });
    }
}
