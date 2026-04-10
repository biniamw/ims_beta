<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeviceidToApptrainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apptrainers', function (Blueprint $table) {
            //
            $table->foreignId('devices_id')->default(1)->constrained()->before('DiscountServiceAmount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apptrainers', function (Blueprint $table) {
            //
            $table->dropColumn('devices_id');
        });
    }
}
