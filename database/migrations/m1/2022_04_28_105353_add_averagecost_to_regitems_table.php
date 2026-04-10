<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAveragecostToRegitemsTable extends Migration
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
            $table->double('averageCost')->nullable()->default(0)->after('MaxCost');
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
            $table->dropColumn('averageCost');
        });
    }
}
