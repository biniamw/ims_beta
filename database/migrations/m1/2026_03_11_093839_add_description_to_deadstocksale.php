<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToDeadstocksale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deadstocksale', function (Blueprint $table) {
            //
            $table->string('Reference')->nullable()->after('VoucherNumber')->default("");
            $table->string('CreatedBy')->nullable()->after('unVoidDate')->default("");
            $table->string('ApprovedBy')->nullable()->after('CheckedDate')->default("");
            $table->string('ApprovedDate')->nullable()->after('ApprovedBy')->default("");
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
        Schema::table('deadstocksale', function (Blueprint $table) {
            //
            $table->dropColumn("Reference");
            $table->dropColumn("CreatedBy");
            $table->dropColumn("ApprovedBy");
            $table->dropColumn("ApprovedDate");
            $table->dropColumn("FiscalYear");
        });
    }
}
