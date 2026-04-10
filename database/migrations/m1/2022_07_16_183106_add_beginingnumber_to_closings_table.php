<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBeginingnumberToClosingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('closings', function (Blueprint $table) {
            //
            $table->string('beginningnumber')->nullable()->after('Common');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('closings', function (Blueprint $table) {
            //
            $table->dropColumn('beginningnumber');
        });
    }
}
