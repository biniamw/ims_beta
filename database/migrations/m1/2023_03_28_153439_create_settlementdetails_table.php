<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlementdetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('settlements_id')->constrained();
            $table->foreignId('sales_id')->constrained();
            $table->string('PaymentType')->default("")->nullable();
            $table->string('BankName')->default("")->nullable();
            $table->string('ChequeNumber')->default("")->nullable();
            $table->string('BankTransferNumber')->default("")->nullable();
            $table->double('SubTotal')->nullable()->default(0);
            $table->double('Tax')->nullable()->default(0);
            $table->double('GrandTotal')->nullable()->default(0);
            $table->double('RemainingAmount')->nullable()->default(0);
            $table->double('WitholdAmount')->nullable()->default(0);
            $table->double('Vat')->nullable()->default(0);
            $table->double('WitholdSetle')->nullable()->default(0);
            $table->double('VatSetle')->nullable()->default(0);
            $table->double('SettlementAmount')->nullable()->default(0);
            $table->integer('SettlementStatus')->nullable()->default(0);
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
        Schema::dropIfExists('settlementdetails');
    }
}
