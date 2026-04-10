<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSealnumToDispatchparents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dispatchparents', function (Blueprint $table) {
            //
            $table->string('SealNumber')->default("")->nullable()->after('ContainerNumber');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dispatchparents', function (Blueprint $table) {
            //
            $table->dropColumn("SealNumber");
        });
    }
}
