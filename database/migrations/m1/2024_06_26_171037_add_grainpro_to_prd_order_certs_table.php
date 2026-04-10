<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGrainproToPrdOrderCertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prd_order_certs', function (Blueprint $table) {
            //
            $table->string('GrainPro')->default("")->nullable()->after('NumofBag');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prd_order_certs', function (Blueprint $table) {
            //
            $table->dropColumn("GrainPro");
        });
    }
}
