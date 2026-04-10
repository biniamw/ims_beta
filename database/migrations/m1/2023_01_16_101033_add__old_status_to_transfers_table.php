<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOldStatusToTransfersTable extends Migration
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
        Schema::table('transfers', function (Blueprint $table) {
            //
            $table->dropColumn('OldStatus');
            $table->dropColumn('UndoVoidBy');
            $table->dropColumn('UndoVoidDate');
        });
    }
}
