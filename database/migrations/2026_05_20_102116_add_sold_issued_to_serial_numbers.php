<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoldIssuedToSerialNumbers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('serial_numbers', function (Blueprint $table) {
            //
            $table->bigInteger('sold_issue_id')->nullable()->default(0)->after('is_sold_issued');
            $table->string('source_type')->nullable()->default("")->after('sold_issue_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('serial_numbers', function (Blueprint $table) {
            //
            $table->dropColumn("sold_issue_id");
            $table->dropColumn("source_type");
        });
    }
}
