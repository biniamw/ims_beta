<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVoucherstToReceivingholdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receivingholds', function (Blueprint $table) {
            //
            $table->integer('VoucherStatus')->nullable()->default(1)->after("PaymentType");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receivingholds', function (Blueprint $table) {
            //
            $table->dropColumn('VoucherStatus');
        });
    }
}
