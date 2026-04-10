<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrainerfeeToServicedetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servicedetails', function (Blueprint $table) {
            //
            $table->double('NewTrainerFee')->nullable()->default(0)->after('Discount');
            $table->double('ExistingTrainerFee')->nullable()->default(0)->after('NewTrainerFee');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servicedetails', function (Blueprint $table) {
            //
            $table->dropColumn('NewTrainerFee');
            $table->dropColumn('ExistingTrainerFee');
        });
    }
}
