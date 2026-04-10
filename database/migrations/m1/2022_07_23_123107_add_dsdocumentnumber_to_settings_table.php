<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDsdocumentnumberToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->string('DSBeginingPrefix')->default(0)->nullable()->after('EndingNumber');
            $table->integer('DSBeginingNumber')->default(0)->nullable()->after('DSBeginingPrefix');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->dropColumn('DSBeginingPrefix');
            $table->dropColumn('DSBeginingNumber');
        });
    }
}
