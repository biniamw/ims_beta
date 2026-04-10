<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFingerprintsToMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('memberships', function (Blueprint $table) {
            //
            $table->longtext('LeftThumb')->default("")->nullable()->before('DateOfJoining');
            $table->longtext('LeftIndex')->default("")->nullable()->before('LeftThumb');
            $table->longtext('LeftMiddle')->default("")->nullable()->before('LeftIndex');
            $table->longtext('LeftRing')->default("")->nullable()->before('LeftMiddle');
            $table->longtext('LeftPinky')->default("")->nullable()->before('LeftRing');
            $table->longtext('RightThumb')->default("")->nullable()->before('LeftPinky');
            $table->longtext('RightIndex')->default("")->nullable()->before('RightThumb');
            $table->longtext('RightMiddle')->default("")->nullable()->before('RightIndex');
            $table->longtext('RightRing')->default("")->nullable()->before('RightMiddle');
            $table->longtext('RightPinky')->default("")->nullable()->before('RightRing');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('memberships', function (Blueprint $table) {
            //
            $table->dropColumn('LeftThumb');
            $table->dropColumn('LeftIndex');
            $table->dropColumn('LeftMiddle');
            $table->dropColumn('LeftRing');
            $table->dropColumn('LeftPinky');
            $table->dropColumn('RightThumb');
            $table->dropColumn('RightIndex');
            $table->dropColumn('RightMiddle');
            $table->dropColumn('RightRing');
            $table->dropColumn('RightPinky');
        });
    }
}
