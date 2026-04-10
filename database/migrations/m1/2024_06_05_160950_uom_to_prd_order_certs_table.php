<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UomToPrdOrderCertsTable extends Migration
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
            $table->foreignId('uoms_id')->default(1)->constrained()->after('CertificateNumber');
            $table->double('NumofBag')->default(0)->nullable()->after('uoms_id');
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
            $table->dropColumn("uoms_id");
            $table->dropColumn("NumofBag");
        });
    }
}
