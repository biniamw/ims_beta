<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpcertToRequisitiondetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisitiondetails', function (Blueprint $table) {
            //
            $table->string('ExportCertNumber')->default("")->nullable()->after('CertNumber');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisitiondetails', function (Blueprint $table) {
            //
            $table->dropColumn("ExportCertNumber");
        });
    }
}
