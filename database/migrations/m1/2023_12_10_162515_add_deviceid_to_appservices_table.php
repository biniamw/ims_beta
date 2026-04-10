<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeviceidToAppservicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appservices', function (Blueprint $table) {
            //
            $table->foreignId('devices_id')->default(1)->constrained()->after('periods_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appservices', function (Blueprint $table) {
            //
            $table->dropColumn('devices_id');
        });
    }
}
