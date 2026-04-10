<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEndingPrefixToSettingsTable extends Migration
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
            $table->string('EndingPrefix')->default(0)->nullable()->after('BeginingNumber');
            $table->integer('EndingNumber')->default(0)->nullable()->after('EndingPrefix');
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
            $table->dropColumn('EndingPrefix');
            $table->dropColumn('EndingNumber');
        });
    }
}
