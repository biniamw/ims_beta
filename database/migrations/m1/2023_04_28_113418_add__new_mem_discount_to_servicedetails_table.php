<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewMemDiscountToServicedetailsTable extends Migration
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
            $table->double('NewMemDiscount')->nullable()->default(0)->after('NewMemberPrice');
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
            $table->dropColumn('NewMemDiscount');
        });
    }
}
