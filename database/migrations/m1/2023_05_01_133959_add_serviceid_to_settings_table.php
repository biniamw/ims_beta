<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceidToSettingsTable extends Migration
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
            $table->string('MemberPrefix')->nullable()->after('ExpireDate');
            $table->integer('MemberNumber')->nullable()->default(0)->after('MemberPrefix');
            $table->string('ApplicationPrefix')->nullable()->after('MemberNumber');
            $table->integer('ApplicationNumber')->nullable()->default(0)->after('ApplicationPrefix');
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
            $table->dropColumn('MemberPrefix');
            $table->dropColumn('MemberNumber');
            $table->dropColumn('ApplicationPrefix');
            $table->dropColumn('ApplicationNumber');
        });
    }
}
