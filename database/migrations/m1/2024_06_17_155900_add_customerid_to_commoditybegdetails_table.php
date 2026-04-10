<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCustomeridToCommoditybegdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commoditybegdetails', function (Blueprint $table) {
            //
            
            $table->string('LocationId')->default("")->nullable()->after('stores_id');
            $table->string('ArrivalDate')->default("")->nullable()->after('LocationId');
            $table->foreignId('customers_id')->default(1)->constrained()->after('commoditybegs_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commoditybegdetails', function (Blueprint $table) {
            //
            $table->dropColumn("LocationId");
            $table->dropColumn("ArrivalDate");
            $table->dropColumn("customers_id");
        });
    }
}
