<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFiscalyearToDeadstockrecs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deadstockrecs', function (Blueprint $table) {
            //
            $table->string('ReceivedDate')->nullable()->after('ReceivedBy')->default("");
            $table->string('CreatedBy')->nullable()->after('Memo')->default("");
            $table->string('CreatedDate')->nullable()->after('CreatedBy')->default("");
            $table->string('FiscalYear')->nullable()->after('IsHide')->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deadstockrecs', function (Blueprint $table) {
            //
            $table->dropColumn("ReceivedDate");
            $table->dropColumn("CreatedBy");
            $table->dropColumn("CreatedDate");
            $table->dropColumn("FiscalYear");
        });
    }
}
