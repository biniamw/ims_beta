<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVoidbyToRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            //
            $table->string('VoidBy')->nullable()->after('RejectedDate');
            $table->string('VoidDate')->nullable()->after('VoidBy');
            $table->string('VoidReason')->nullable()->after('VoidDate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            //
            $table->dropColumn('VoidBy');
            $table->dropColumn('VoidDate');
            $table->dropColumn('VoidReason');
        });
    }
}
