<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdjprefixToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->string('adjustment_owner_doc_prefix')->default("")->nullable()->after('ending_customer_doc_prefix');
            $table->string('adjustment_customer_doc_prefix')->default("")->nullable()->after('adjustment_owner_doc_prefix');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
            $table->dropColumn("adjustment_owner_doc_prefix");
            $table->dropColumn("adjustment_customer_doc_prefix");
        });
    }
}
