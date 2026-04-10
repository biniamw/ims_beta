<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReasonToAdjustmentdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('adjustmentdetails', function (Blueprint $table) {
            //
            $table->string('Reason')->nullable()->after('Memo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adjustmentdetails', function (Blueprint $table) {
            //
            $table->dropColumn('Reason');
        });
    }
}
