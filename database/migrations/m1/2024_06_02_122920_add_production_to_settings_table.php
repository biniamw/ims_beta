<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProductionToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('PrdOwnerPrefix')->nullable();
            $table->integer('PrdOwnerNumber')->default(0)->nullable();
            $table->string('PrdCustomerPrefix')->nullable();
            $table->integer('PrdCustomerNumber')->default(0)->nullable();
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
            $table->dropColumn("PrdOwnerPrefix");
            $table->dropColumn("PrdOwnerNumber");
            $table->dropColumn("PrdCustomerPrefix");
            $table->dropColumn("PrdCustomerNumber");
        });
    }
}
