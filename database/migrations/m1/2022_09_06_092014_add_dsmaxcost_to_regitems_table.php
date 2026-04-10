<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDsmaxcostToRegitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('regitems', function (Blueprint $table) {
            //
            $table->double('dsmaxcost')->default(0)->nullable()->after('DeadStockPrice');
            $table->double('dsmaxcosteditable')->default(0)->nullable()->after('dsmaxcost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('regitems', function (Blueprint $table) {
            //
            $table->dropColumn('dsmaxcost');
            $table->dropColumn('dsmaxcosteditable');
        });
    }
}
