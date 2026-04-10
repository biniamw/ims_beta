<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProcdataToReceivingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receivings', function (Blueprint $table) {
            //
            $table->string('PoId')->default()->nullable()->after('IsSeparatelySettled');
            $table->string('ProductType')->default(1)->nullable()->after('PoId');
            $table->string('CommoditySource')->default("")->nullable()->after('ProductType');
            $table->string('CommodityType')->default("")->nullable()->after('CommoditySource');
            $table->string('CompanyType')->default("")->nullable()->after('CommodityType');
            $table->string('CustomerOrOwner')->default(1)->nullable()->after('CompanyType');
            $table->string('DeliveryOrderNo')->default("")->nullable()->after('CustomerOrOwner');
            $table->string('DispatchStation')->default("")->nullable()->after('DeliveryOrderNo');
            $table->string('DriverName')->default("")->nullable()->after('DispatchStation');
            $table->string('TruckPlateNo')->default("")->nullable()->after('DriverName');
            $table->string('DriverPhoneNo')->default("")->nullable()->after('TruckPlateNo');
            $table->string('ReceivedDate')->default("")->nullable()->after('DriverPhoneNo');
            $table->string('CurrentDocumentNumber')->default("")->nullable()->after('ReceivedDate');
            $table->string('IsFromProcurement')->default(0)->nullable()->after('CurrentDocumentNumber');
            $table->string('InvoiceStatus')->default(0)->nullable()->after('IsFromProcurement');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receivings', function (Blueprint $table) {
            //
            $table->dropColumn("PoId");
            $table->dropColumn("ProductType");
            $table->dropColumn("CommoditySource");
            $table->dropColumn("CommodityType");
            $table->dropColumn("CompanyType");
            $table->dropColumn("CustomerOrOwner");
            $table->dropColumn("DeliveryOrderNo");
            $table->dropColumn("DispatchStation");
            $table->dropColumn("DriverName");
            $table->dropColumn("TruckPlateNo");
            $table->dropColumn("DriverPhoneNo");
            $table->dropColumn("ReceivedDate");
            $table->dropColumn("CurrentDocumentNumber");
            $table->dropColumn("IsFromProcurement");
            $table->dropColumn("InvoiceStatus");
        });
    }
}
