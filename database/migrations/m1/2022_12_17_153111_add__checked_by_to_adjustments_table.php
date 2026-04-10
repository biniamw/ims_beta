<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCheckedByToAdjustmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adjustments', function (Blueprint $table) {
            //
            $table->string('StatusOld')->nullable()->after('Status');
            $table->string('CheckedBy')->nullable()->after('StatusOld');
            $table->string('CheckedDate')->nullable()->after('CheckedBy');
            $table->string('ConfirmedBy')->nullable()->after('CheckedDate');
            $table->string('ConfirmedDate')->nullable()->after('ConfirmedBy');
            $table->string('ChangetoPendingBy')->nullable()->after('ConfirmedDate');
            $table->string('ChangetoPendingDate')->nullable()->after('ChangetoPendingBy');
            $table->string('VoidBy')->nullable()->after('ChangetoPendingDate');
            $table->string('VoidDate')->nullable()->after('VoidBy');
            $table->string('UndoVoidBy')->nullable()->after('VoidDate');
            $table->string('UndoVoidDate')->nullable()->after('UndoVoidBy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adjustments', function (Blueprint $table) {
            //
            $table->dropColumn('StatusOld');
            $table->dropColumn('CheckedBy');
            $table->dropColumn('CheckedDate');
            $table->dropColumn('ConfirmedBy');
            $table->dropColumn('ConfirmedDate');
            $table->dropColumn('ChangetoPendingBy');
            $table->dropColumn('ChangetoPendingDate');
            $table->dropColumn('VoidBy');
            $table->dropColumn('VoidDate');
            $table->dropColumn('UndoVoidBy');
            $table->dropColumn('UndoVoidDate');
        });
    }
}
