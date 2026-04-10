<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPercentageToPrdOutputs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prd_outputs', function (Blueprint $table) {
            //
            $table->double('Percentage')->default(0)->nullable()->after('VarianceOverage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prd_outputs', function (Blueprint $table) {
            //
            $table->dropColumn("Percentage");
        });
    }
}
