<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeclosingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomeclosings', function (Blueprint $table) {
            $table->id();
            $table->string('IncomeDocumentNumber')->nullable();
            $table->foreignId('stores_id')->constrained();
            $table->string('StartDate')->default("")->nullable();
            $table->string('EndDate')->default("")->nullable();
            $table->double('TotalCashDeposited')->nullable()->default(0);
            $table->double('TotalCash')->nullable()->default(0);
            $table->double('WitholdAmount')->nullable()->default(0);
            $table->double('VatAmount')->nullable()->default(0);
            $table->double('OtherIncome')->nullable()->default(0);
            $table->double('NetCashReceived')->nullable()->default(0);
            $table->double('TotalZAmount')->nullable()->default(0);
            $table->string('PreparedBy')->default("")->nullable();
            $table->string('PreparedDate')->default("")->nullable();
            $table->string('VerifiedBy')->default("")->nullable();
            $table->string('VerifiedDate')->default("")->nullable();
            $table->string('ConfirmedBy')->default("")->nullable();
            $table->string('ConfirmedDate')->default("")->nullable();
            $table->string('ChangeToPendingBy')->default("")->nullable();
            $table->string('ChangeToPendingDate')->default("")->nullable();
            $table->string('LastEditedBy')->default("")->nullable();
            $table->string('LastEditedDate')->default("")->nullable();
            $table->string('Memo')->default("")->nullable();
            $table->string('Status')->default("")->nullable();
            $table->string('OldStatus')->default("")->nullable();
            $table->string('IsVoid')->default("0")->nullable();
            $table->string('VoidBy')->default("")->nullable();
            $table->string('VoidReason')->default("")->nullable();
            $table->string('VoidDate')->default("")->nullable();
            $table->string('UndoVoidBy')->default("")->nullable();
            $table->string('UndoVoidReason')->default("")->nullable();
            $table->string('UndoVoidDate')->default("")->nullable();
            $table->string('ZDocumentName',"65535")->nullable();
            $table->string('ZDocumentPath',"65535")->nullable();
            $table->string('SlipDocumentName',"65535")->nullable();
            $table->string('SlipDocumentPath',"65535")->nullable();
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
        Schema::dropIfExists('incomeclosings');
    }
}
