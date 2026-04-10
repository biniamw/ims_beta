<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegitemConsignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignment_regitem', function (Blueprint $table) {
            $table->id();
            $table->foreignId('regitem_id')->constrained();
            $table->foreignId('consignment_id')->constrained();
            $table->double('Quantity',15,2)->nullable()->default(0);
            $table->string('Dprice')->nullable();
            $table->double('UnitPrice',15,2)->nullable()->default(0);
            $table->double('Discount',15,2)->nullable()->default(0);
            $table->double('DiscountAmount',15,2)->nullable()->default(0);
            $table->double('BeforeTaxPrice',15,2)->nullable()->default(0);
            $table->double('TaxAmount',15,2)->nullable()->default(0);
            $table->double('TotalPrice',15,2)->nullable()->default(0);
            $table->foreignId('store_id')->constrained();
            $table->integer('LocationId')->nullable();
            $table->double('RetailerPrice',15,2)->nullable()->default(0);
            $table->double('Wholeseller',15,2)->nullable()->default(0);
            $table->date('Date')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('RequireSerialNumber')->nullable();
            $table->date(' RequireExpireDate')->nullable();
            $table->double('ConvertedQuantity',15,2)->nullable()->default(0);
            $table->double('ConversionAmount',15,2)->nullable()->default(0);
            $table->integer('NewUOMId')->nullable()->default(0);
            $table->integer('DefaultUOMId')->nullable()->default(0);
            $table->integer('IsVoid')->nullable();
            $table->string('Memo')->nullable();
            $table->integer('Common')->nullable()->default(0);
            $table->string('TransactionType')->nullable();
            $table->string('ItemType')->nullable();
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
        Schema::dropIfExists('consignment_regitem');
    }
}
