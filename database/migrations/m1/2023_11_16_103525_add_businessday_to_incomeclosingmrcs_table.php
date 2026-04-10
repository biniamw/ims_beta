<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBusinessdayToIncomeclosingmrcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incomeclosingmrcs', function (Blueprint $table) {
            //
            $table->integer('BusinessDay')->nullable()->default(0)->after('TotalAmount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incomeclosingmrcs', function (Blueprint $table) {
            //
            $table->dropColumn('BusinessDay');
        });
    }
}
