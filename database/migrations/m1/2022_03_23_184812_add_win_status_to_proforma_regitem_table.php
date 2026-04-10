<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWinStatusToProformaRegitemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proforma_regitem', function (Blueprint $table) {
            //
            $table->string('winStatus')->nullable()->after('Date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proforma_regitem', function (Blueprint $table) {
            //
            $table->dropColumn('winStatus');
        });
    }
}
