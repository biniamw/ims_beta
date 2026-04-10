<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFiscalyearToReceivingholdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receivingholds', function (Blueprint $table) {
            //
            $table->string('fiscalyear')->nullable()->after('Common');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receivingholds', function (Blueprint $table) {
            //
            $table->dropColumn('fiscalyear');    
        });
    }
}
