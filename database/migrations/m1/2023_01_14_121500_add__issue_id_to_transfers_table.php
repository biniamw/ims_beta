<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIssueIdToTransfersTable extends Migration
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
            $table->string('IssueDocNumber')->nullable()->default("")->after('DocumentNumber');
            $table->string('DeliveredBy')->nullable()->default("")->after('VoidReason');
            $table->string('DeliveredDate')->nullable()->default("")->after('DeliveredBy');
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
            $table->dropColumn('IssueDocNumber');
            $table->dropColumn('DeliveredBy');
            $table->dropColumn('DeliveredDate');
        });
    }
}
