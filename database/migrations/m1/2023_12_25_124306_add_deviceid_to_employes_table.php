<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeviceidToEmployesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employes', function (Blueprint $table) {
            //
            $table->foreignId('devices_id')->default(1)->constrained()->before('Status');
            $table->string('PersonUUID',"65535")->default('')->nullable()->before('Status');
            $table->longtext('LeftThumb')->default("")->nullable()->before('EmergencyLocation');
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
        Schema::table('employes', function (Blueprint $table) {
            //
            $table->dropColumn('devices_id');
            $table->dropColumn('PersonUUID');
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
