<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUndoVoidByToReceivingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receivings', function (Blueprint $table) {
            //
            $table->string('UndoVoidBy')->nullable()->after('ChangeToPendingDate');
            $table->string('UndoVoidDate')->nullable()->after('UndoVoidBy');
            $table->string('EditConfirmedBy')->nullable()->after('UndoVoidDate');
            $table->string('EditConfirmedDate')->nullable()->after('EditConfirmedBy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receivings', function (Blueprint $table) {
            //
            $table->dropColumn('UndoVoidBy');
            $table->dropColumn('UndoVoidDate');
            $table->dropColumn('EditConfirmedBy');
            $table->dropColumn('EditConfirmedDate');
        });
    }
}
