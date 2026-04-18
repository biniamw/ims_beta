<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFormuuidToReceivings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receivings', function (Blueprint $table) {
            //
            $table->string('form_uuid')->nullable()->after('Common')->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receivings', function (Blueprint $table) {
            //
            $table->dropColumn("form_uuid");
        });
    }
}
