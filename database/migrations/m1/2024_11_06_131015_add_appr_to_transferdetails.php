<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprToTransferdetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transferdetails', function (Blueprint $table) {
            //
            $table->double('ApprovedQuantity')->default(0)->nullable()->after('Quantity');
            $table->double('IssuedQuantity')->default(0)->nullable()->after('ApprovedQuantity');
            $table->string('ApprovedMemo')->default()->nullable()->after('Memo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transferdetails', function (Blueprint $table) {
            //
            $table->dropColumn("ApprovedQuantity");
            $table->dropColumn("IssuedQuantity");
            $table->dropColumn("ApprovedMemo");
        });
    }
}
