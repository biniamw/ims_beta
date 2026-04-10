<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentivoiceToReceivingdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receivingdetails', function (Blueprint $table) {
            //
            $table->string('PurchaseInvoiceId')->default()->nullable()->after('PoDetId');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receivingdetails', function (Blueprint $table) {
            //
            $table->dropColumn("PurchaseInvoiceId");
        });
    }
}
