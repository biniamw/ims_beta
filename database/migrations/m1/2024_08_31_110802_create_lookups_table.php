<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLookupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lookups', function (Blueprint $table) {
            $table->id();
            $table->string('CommodityTypeValue')->default()->nullable();
            $table->string('CommodityType')->default()->nullable();
            $table->string("CommodityTypeStatus")->default()->nullable();
            $table->string('GradeValue')->default()->nullable();
            $table->string('Grade')->default()->nullable();
            $table->string("GradeStatus")->default()->nullable();
            $table->string('ProcessTypeValue')->default()->nullable();
            $table->string('ProcessType')->default()->nullable();
            $table->string("ProcessTypeStatus")->default()->nullable();
            $table->string('CropYearValue')->default()->nullable();
            $table->string('CropYear')->default()->nullable();
            $table->string("CropYearStatus")->default()->nullable();
            $table->string('RequestReasonValue')->default()->nullable();
            $table->string('RequestReason')->default()->nullable();
            $table->string("RequestReasonStatus")->default()->nullable();
            $table->string('ProductTypeValue')->default()->nullable();
            $table->string('ProductType')->default()->nullable();
            $table->string("ProductTypeStatus")->default()->nullable();
            $table->string('CompanyTypeValue')->default()->nullable();
            $table->string('CompanyType')->default()->nullable();
            $table->string("CompanyTypeStatus")->default()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lookups');
    }
}
