<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShowonpayrollToSalarytypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('salarytypes', function (Blueprint $table) {
            //
            $table->integer('show_on_payroll')->nullable()->default(0)->after('Description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('salarytypes', function (Blueprint $table) {
            //
            $table->dropColumn("show_on_payroll");
        });
    }
}
