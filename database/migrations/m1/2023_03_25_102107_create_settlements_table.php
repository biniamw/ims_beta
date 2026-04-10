<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettlementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settlements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stores_id')->constrained();
            $table->foreignId('customers_id')->constrained();
            $table->string('CrvNumber')->default("")->nullable();
            $table->string('DocumentDate')->default("")->nullable();
            $table->double('OutstandingAmount')->nullable()->default(0);
            $table->double('SettlementAmount')->nullable()->default(0);
            $table->double('UnSettlementAmount')->nullable()->default(0);
            $table->string('SettledBy')->default("")->nullable();
            $table->string('SettledDate')->default("")->nullable();
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
        Schema::dropIfExists('settlements');
    }
}
