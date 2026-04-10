<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVoidDateReasonToAdjustmentsTable extends Migration
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
            $table->string('VoidReason')->nullable()->after('VoidDate');
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
        Schema::table('adjustments', function (Blueprint $table) {
            //
            $table->dropColumn('VoidReason');
            $table->dropColumn('EditConfirmedBy');
            $table->dropColumn('EditConfirmedDate');
        });
    }
}
