<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIssueDocNumberToRequisitionsTable extends Migration
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
            $table->string('IssueDocNumber')->nullable()->default("")->after('DocumentNumber');
            $table->string('OldStatus')->nullable()->default("")->after('Status');
            $table->string('UndoVoidBy')->nullable()->default("")->after('VoidReason');
            $table->string('UndoVoidDate')->nullable()->default("")->after('UndoVoidBy');
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
            $table->dropColumn('IssueDocNumber');
            $table->dropColumn('OldStatus');
            $table->dropColumn('UndoVoidBy');
            $table->dropColumn('UndoVoidDate');
        });
    }
}
