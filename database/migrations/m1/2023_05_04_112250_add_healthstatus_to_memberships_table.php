<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHealthstatusToMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('memberships', function (Blueprint $table) {
            //
            $table->string('MemberId')->nullable()->after('id');
            $table->string('HealthStatus')->nullable()->after('Occupation');
            $table->string('Memo')->nullable()->after('HealthStatus');
            $table->string('Picture')->nullable()->after('Memo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memberships', function (Blueprint $table) {
            //
            $table->dropColumn('MemberId');
            $table->dropColumn('HealthStatus');
            $table->dropColumn('Memo');
            $table->dropColumn('Picture');
        });
    }
}
