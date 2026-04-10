<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsPriceVoidToDeadstocktransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deadstocktransaction', function (Blueprint $table) {
            //
            $table->integer('IsPriceVoid')->nullable()->default(0)->after('IsVoid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deadstocktransaction', function (Blueprint $table) {
            //
            $table->dropColumn('IsPriceVoid');
        });
    }
}
