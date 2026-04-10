<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDispmodeToLookupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lookups', function (Blueprint $table) {
            //
            $table->string('DispatchModeValue')->default("")->nullable()->after('ProductionTypeStatus');
            $table->string('DispatchModeName')->default("")->nullable()->after('DispatchModeValue');
            $table->string('DispatchModeStatus')->default("")->nullable()->after('DispatchModeName');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lookups', function (Blueprint $table) {
            //
            $table->dropColumn("DispatchModeValue");
            $table->dropColumn("DispatchModeName");
            $table->dropColumn("DispatchModeStatus");
        });
    }
}
