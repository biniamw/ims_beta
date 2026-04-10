<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSymbolToWoredasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('woredas', function (Blueprint $table) {
            //
            $table->string('Symbol')->default("")->nullable()->after('Wh_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('woredas', function (Blueprint $table) {
            //
            $table->dropColumn("Symbol");
        });
    }
}
