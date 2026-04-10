<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToAppconsolidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appconsolidates', function (Blueprint $table) {
            //
            $table->integer('type')->nullable()->default(0)->after('periods_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appconsolidates', function (Blueprint $table) {
            //
            $table->dropColumn('type');
        });
    }
}
