<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEndingdocprToSettings extends Migration
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
            $table->integer('customers_id')->default("")->nullable()->after('StatusOld');
            $table->string('product_type')->default("")->nullable()->after('customers_id');
            $table->string('last_doc_number')->default("")->nullable()->after('product_type');
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
            $table->dropColumn("customers_id");
            $table->dropColumn("product_type");
            $table->dropColumn("last_doc_number");
        });
    }
}
