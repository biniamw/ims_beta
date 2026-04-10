<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocnumToPrdBomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prd_boms', function (Blueprint $table) {
            //
            $table->string("BomNumber")->nullable()->after('id');
            $table->integer('BomChildNumber')->default(0)->nullable()->after('Status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prd_boms', function (Blueprint $table) {
            //
            $table->dropColumn("BomNumber");
            $table->dropColumn("BomChildNumber");
        });
    }
}
