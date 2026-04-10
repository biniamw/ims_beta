<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoyaltystatusToAppmembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appmembers', function (Blueprint $table) {
            //
            $table->string('LoyalityStatus')->nullable()->after('Status');
            $table->string('OldLoyalityStatus')->nullable()->after('LoyalityStatus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appmembers', function (Blueprint $table) {
            //
            $table->dropColumn('LoyalityStatus');
            $table->dropColumn('OldLoyalityStatus');
        });
    }
}
