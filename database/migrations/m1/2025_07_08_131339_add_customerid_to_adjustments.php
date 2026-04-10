<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomeridToAdjustments extends Migration
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
            $table->integer('customers_id')->default(0)->nullable()->after('StatusOld');
            $table->string('product_type')->default("")->nullable()->after('customers_id');
            $table->string('company_type')->default("")->nullable()->after('product_type');
            $table->string('last_doc_number')->default("")->nullable()->after('company_type');
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
            $table->dropColumn("customers_id");
            $table->dropColumn("product_type");
            $table->dropColumn("company_type");
            $table->dropColumn("last_doc_number");
        });
    }
}
