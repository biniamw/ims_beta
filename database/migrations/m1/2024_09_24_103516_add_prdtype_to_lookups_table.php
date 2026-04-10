<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPrdtypeToLookupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('lookups', function (Blueprint $table) {
            //
            $table->string('ProductionTypeValue')->default("")->nullable()->after('CompanyTypeStatus');
            $table->string('ProductionType')->default("")->nullable()->after('ProductionTypeValue');
            $table->string('ProductionTypeStatus')->default("")->nullable()->after('ProductionType');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lookups', function (Blueprint $table) {
            //
            $table->dropColumn("ProductionTypeValue");
            $table->dropColumn("ProductionType");
            $table->dropColumn("ProductionTypeStatus");
        });
    }
}
