<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('groupmembers_id')->constrained();
            $table->foreignId('paymentterms_id')->constrained();
            $table->foreignId('stores_id')->constrained();
            $table->string('ApplicationNumber')->nullable();
            $table->string('RegistrationDate')->nullable();
            $table->string('ExpiryDate')->nullable();
            $table->string('Type')->nullable();
            $table->string('TIN')->nullable();
            $table->string('VoucherType')->nullable();
            $table->string('Mrc')->nullable();
            $table->string('PaymentType')->nullable();
            $table->string('VoucherNumber')->nullable();
            $table->string('InvoiceNumber')->nullable();
            $table->string('InvoiceDate')->nullable();
            $table->double('SubTotal')->nullable()->default(0);
            $table->double('TotalTax')->nullable()->default(0);
            $table->double('GrandTotal')->nullable()->default(0);
            $table->double('DiscountPercent')->nullable()->default(0);
            $table->double('DiscountAmount')->nullable()->default(0);
            $table->string('PreparedBy')->nullable();
            $table->string('PreparedDate')->nullable();
            $table->string('VerifiedBy')->nullable();
            $table->string('VerifiedDate')->nullable();
            $table->string('LastEditedBy')->nullable();
            $table->string('LastEditedDate')->nullable();
            $table->double('IsVoid')->nullable()->default(0);
            $table->string('VoidBy')->nullable();
            $table->string('VoidDate')->nullable();
            $table->string('VoidReason')->nullable();
            $table->string('UndoVoidBy')->nullable();
            $table->string('UndoVoidDate')->nullable();
            $table->string('Memo')->nullable();
            $table->string('Status',100)->nullable();
            $table->string('OldStatus',100)->nullable();
            $table->string('ApplicationType')->nullable();
            $table->integer('RenewParentId')->nullable()->default(0);
            $table->string('FiscalYear')->nullable();
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
        Schema::dropIfExists('applications');
    }
}
