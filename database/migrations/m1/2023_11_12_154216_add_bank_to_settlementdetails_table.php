<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankToSettlementdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settlementdetails', function (Blueprint $table) {
            //
            $table->foreignId('banks_id')->constrained()->after('sales_id');
            $table->foreignId('bankdetails_id')->constrained()->after('sales_id');
            $table->foreign('bankdetails_id')->references('id')->on('bankdetails');
            $table->string('Remark')->default("")->nullable()->after('SettlementStatus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settlementdetails', function (Blueprint $table) {
            //
            $table->dropColumn('banks_id');
            $table->dropColumn('bankdetails_id');
            $table->dropColumn('Remark');
        });
    }
}
