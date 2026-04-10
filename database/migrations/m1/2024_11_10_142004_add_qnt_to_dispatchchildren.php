<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQntToDispatchchildren extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dispatchchildren', function (Blueprint $table) {
            //
            $table->double('Quantity')->default(0)->nullable()->after('dispatchparents_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dispatchchildren', function (Blueprint $table) {
            //
            $table->dropColumn("Quantity");
        });
    }
}
