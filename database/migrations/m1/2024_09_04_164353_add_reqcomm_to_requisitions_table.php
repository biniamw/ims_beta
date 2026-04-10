<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReqcommToRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            $table->string('CompanyType')->default()->nullable()->after('Type');
            $table->string('RequestReason')->default()->nullable()->after('Purpose');
            $table->string('CustomerOrOwner')->default()->nullable()->after('RequestReason');
            $table->string('Reference')->default()->nullable()->after('CustomerOrOwner');
            $table->string('BookingNumber')->default("")->nullable()->after('Reference');
            $table->string('LabStation')->default("")->nullable()->after('BookingNumber');
            $table->string('DriverName')->default("")->nullable()->after('LabStation');
            $table->string('TruckPlateNo')->default("")->nullable()->after('DriverName');
            $table->string('DriverPhoneNo')->default("")->nullable()->after('TruckPlateNo');
            $table->string('DriverLicenseNo')->default("")->nullable()->after('DriverPhoneNo');
            $table->string('ContainerNo')->default("")->nullable()->after('DriverLicenseNo');
            $table->string('CurrentDocumentNumber')->default("")->nullable()->after('ContainerNo');
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
            $table->dropColumn("CompanyType");
            $table->dropColumn("RequestReason");
            $table->dropColumn("CustomerOrOwner");
            $table->dropColumn("Reference");
            $table->dropColumn("BookingNumber");
            $table->dropColumn("LabStation");
            $table->dropColumn("DriverName");
            $table->dropColumn("TruckPlateNo");
            $table->dropColumn("DriverPhoneNo");
            $table->dropColumn("DriverLicenseNo");
            $table->dropColumn("ContainerNo");
            $table->dropColumn("CurrentDocumentNumber");
        });
    }
}
