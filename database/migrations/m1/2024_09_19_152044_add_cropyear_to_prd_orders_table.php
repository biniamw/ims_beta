<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCropyearToPrdOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prd_orders', function (Blueprint $table) {
            //
            $table->string('CropYear')->default("")->nullable()->after('woredas_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prd_orders', function (Blueprint $table) {
            //
            $table->dropColumn("CropYear");
        });
    }
}
