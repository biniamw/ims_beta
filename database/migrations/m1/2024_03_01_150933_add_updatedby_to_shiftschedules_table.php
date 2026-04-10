<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUpdatedbyToShiftschedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shiftschedules', function (Blueprint $table) {
            //
            $table->string('LastEditedBy')->default("")->nullable()->after('CreatedBy');
            $table->string('LastEditedDate')->default("")->nullable()->after('LastEditedBy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shiftschedules', function (Blueprint $table) {
            //
            $table->dropColumn('LastEditedBy');
            $table->dropColumn('LastEditedDate');
        });
    }
}
