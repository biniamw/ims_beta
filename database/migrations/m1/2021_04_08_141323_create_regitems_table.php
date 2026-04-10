<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegitemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regitems', function (Blueprint $table) {
            $table->id();
            $table->string('Name')->unique();
            $table->string('Code')->unique();
            $table->integer('MeasurementId');
            $table->integer('CategoryId');
            $table->decimal('RetailerPrice');
            $table->decimal('WholesellerPrice');
            $table->string('TaxTypeId');
            $table->string('RequireSerialNumber');
            $table->string('RequireExpireDate');
            $table->string('PartNumber');
            $table->string('Description');
            $table->string('SKUNumber');
            $table->string('BarcodeImage');
            $table->string('BarcodeType');
            $table->string('ActiveStatus');
            $table->string('IsDeleted');
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
        Schema::dropIfExists('regitems');
    }
}
