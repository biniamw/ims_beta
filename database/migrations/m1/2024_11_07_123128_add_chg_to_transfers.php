<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChgToTransfers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfers', function (Blueprint $table) {
            //
            $table->string('ChangeToPendingBy')->default()->nullable()->after('TransferDate');
            $table->string('ChangeToPendingDate')->default()->nullable()->after('ChangeToPendingBy');
            $table->string('ReviewedBy')->default()->nullable()->after('AuthorizedBy');
            $table->string('ReviewedDate')->default()->nullable()->after('ReviewedBy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfers', function (Blueprint $table) {
            //
            $table->dropColumn("ChangeToPendingBy");
            $table->dropColumn("ChangeToPendingDate");
            $table->dropColumn("ReviewedBy");
            $table->dropColumn("ReviewedDate");
        });
    }
}
