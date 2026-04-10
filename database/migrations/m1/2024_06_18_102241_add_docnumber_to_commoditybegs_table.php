<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocnumberToCommoditybegsTable extends Migration
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
            $table->string('LastDocNumber')->default("")->nullable()->after('Status');
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
            $table->dropColumn("LastDocNumber");
        });
    }
}
