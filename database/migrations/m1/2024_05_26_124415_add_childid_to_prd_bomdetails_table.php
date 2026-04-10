<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddChildidToPrdBomdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prd_bomdetails', function (Blueprint $table) {
            //
            $table->foreignId('prd_bomchildren_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prd_bomdetails', function (Blueprint $table) {
            //
            $table->dropColumn("prd_bomchildren_id");
        });
    }
}
