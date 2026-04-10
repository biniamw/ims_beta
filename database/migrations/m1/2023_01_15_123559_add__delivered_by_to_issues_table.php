<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeliveredByToIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issues', function (Blueprint $table) {
            //
            $table->string('DeliveredBy')->nullable()->default("")->after('RejectedDate');
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
        Schema::table('issues', function (Blueprint $table) {
            //
            $table->dropColumn('DeliveredBy');
            $table->dropColumn('DeliveredDate');
        });
    }
}
