<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClosingdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closingdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('header_id')->default(0);
            $table->integer('item_id')->default(0);
            $table->double('Quantity')->nullable();
            $table->double('PhysicalCount')->nullable();
            $table->double('ShortageVariance')->nullable();
            $table->double('OverageVariance')->nullable();
            $table->double('UnitCost')->nullable();
            $table->double('BeforeTaxCost')->nullable();
            $table->double('TaxAmount')->nullable();
            $table->double('TotalCost')->nullable();
            $table->integer('store_id')->nullable();
            $table->integer('deststore_id')->nullable();
            $table->integer('location_id')->nullable();
            $table->double('RetailerPrice')->nullable();
            $table->double('Wholeseller')->nullable();
            $table->string('Date')->nullable();
            $table->string('RequireSerialNumber')->nullable();
            $table->string('RequireExpireDate')->nullable();
            $table->double('ConvertedQuantity')->nullable();
            $table->double('ConversionAmount')->nullable();
            $table->integer('newuom_id')->nullable();
            $table->integer('defaultuom_id')->nullable();
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
        Schema::dropIfExists('closingdetails');
    }
}
