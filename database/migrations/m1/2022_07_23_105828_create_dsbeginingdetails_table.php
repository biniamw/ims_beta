<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDsbeginingdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dsbeginingdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('HeaderId')->default(0);
            $table->integer('ItemId')->default(0);
            $table->double('Quantity')->nullable();
            $table->double('PhysicalCount')->nullable();
            $table->double('ShortageVariance')->nullable();
            $table->double('OverageVariance')->nullable();
            $table->double('UnitCost')->nullable();
            $table->double('BeforeTaxCost')->nullable();
            $table->double('TaxAmount')->nullable();
            $table->double('TotalCost')->nullable();
            $table->integer('StoreId')->nullable();
            $table->integer('DestStoreId')->nullable();
            $table->integer('LocationId')->nullable();
            $table->double('RetailerPrice')->nullable();
            $table->double('Wholeseller')->nullable();
            $table->string('Date')->nullable();
            $table->string('RequireSerialNumber')->nullable();
            $table->string('RequireExpireDate')->nullable();
            $table->double('ConvertedQuantity')->nullable();
            $table->double('ConversionAmount')->nullable();
            $table->integer('NewUOMId')->nullable();
            $table->integer('DefaultUOMId')->nullable();
            $table->string('ItemType')->nullable();
            $table->string('PartNumber')->nullable();
            $table->string('Memo')->nullable();
            $table->string('Common')->nullable();
            $table->string('TransactionType')->nullable();
            $table->string('SerialNumbers')->nullable();
            $table->string('SerialNumberFlag')->nullable()->default(0);
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
        Schema::dropIfExists('dsbeginingdetails');
    }
}
