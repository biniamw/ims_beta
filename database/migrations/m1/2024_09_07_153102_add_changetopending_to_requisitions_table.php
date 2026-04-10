<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChangetopendingToRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            //
            $table->string('ChangeToPendingBy')->default("")->nullable()->after('RequestDate');
            $table->string('ChangeToPendingDate')->default("")->nullable()->after('ChangeToPendingBy');
            $table->string('DispatchDocumentNo')->default("")->nullable()->after('UndoVoidDate');
            $table->string('DispatchNumber')->default("")->nullable()->after('DispatchDocumentNo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            //
            $table->dropColumn("ChangeToPendingBy");
            $table->dropColumn("ChangeToPendingDate");
            $table->dropColumn("DispatchDocumentNo");
            $table->dropColumn("DispatchNumber");
        });
    }
}
