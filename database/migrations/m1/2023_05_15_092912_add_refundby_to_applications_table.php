<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefundbyToApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            //
            $table->string('RefundBy')->nullable()->after('UndoVoidDate');
            $table->string('RefundDate')->nullable()->after('RefundBy');
            $table->string('RefundReason')->nullable()->after('RefundDate');
            $table->string('UndoRefundBy')->nullable()->after('RefundReason');
            $table->string('UndoRefundDate')->nullable()->after('UndoRefundBy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            //
            $table->dropColumn('RefundBy');
            $table->dropColumn('RefundDate');
            $table->dropColumn('RefundReason');
            $table->dropColumn('UndoRefundBy');
            $table->dropColumn('UndoRefundDate');
        });
    }
}
