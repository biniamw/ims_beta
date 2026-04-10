<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('CustomerId')->nullable();
            $table->string('PaymentType')->nullable();
            $table->string('VoucherType')->nullable();
            $table->string('VoucherNumber')->nullable();
            $table->string('CustomerMRC')->nullable();
            $table->bigInteger('StoreId')->nullable();
            $table->string('PurchaserName')->nullable();
            $table->string('IsVoid')->nullable();
            $table->text('VoidReason')->nullable();
            $table->string('VoidedBy')->nullable();
            $table->date('VoidedDate')->nullable();
            $table->date('TransactionDate')->nullable();
            $table->float('WitholdPercent')->nullable();
            $table->double('WitholdAmount',15,2)->nullable()->default(0);
            $table->float('DiscountPercent')->nullable();
            $table->float('DiscountAmount')->nullable();
            $table->double('SubTotal',15,2)->nullable()->default(0);
            $table->double('Tax',15,2)->nullable()->default(0);
            $table->double('GrandTotal',15,2)->nullable()->default(0);
            $table->double('NetPay',15,2)->nullable()->default(0);
            $table->double('Vat',15,2)->nullable()->default(0);
            $table->string('Status')->nullable();
            $table->string('OldStatus')->nullable();
            $table->string('Username')->nullable();
            $table->string('Common')->nullable();
            $table->string('CheckedBy')->nullable();
            $table->string('CheckedDate')->nullable();
            $table->string('ConfirmedBy')->nullable();
            $table->date('ConfirmedDate')->nullable();
            $table->string('ChangeToPendingBy')->nullable();
            $table->date('ChangeToPendingDate')->nullable();
            $table->date('CreatedDate')->nullable();
            $table->string('RefundBy')->nullable();
            $table->date('RefundDate')->nullable();
            $table->text('RefundReason')->nullable();
            $table->string('UnvoidBy')->nullable();
            $table->date('UnVoidDate')->nullable();
            $table->string('WitholdSetle')->nullable();
            $table->string('VatSetle')->nullable();
            $table->string('witholdNumber')->nullable();
            $table->string('vatNumber')->nullable();
            $table->string('consignmentType')->nullable();
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
        Schema::dropIfExists('consignments');
    }
}
