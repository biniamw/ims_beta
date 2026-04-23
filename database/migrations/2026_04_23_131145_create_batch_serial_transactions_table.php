<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchSerialTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_serial_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batches_id')->constrained();
            $table->integer('serial_number_id')->nullable()->default(0);
            $table->bigInteger('in_quantity')->nullable()->default(0);
            $table->bigInteger('out_quantity')->nullable()->default(0);
            $table->foreignId('stores_id')->constrained();
            $table->bigInteger('reference_id')->nullable()->default(0);
            $table->string('reference_number')->nullable()->default("");
            $table->string('transaction_type')->nullable()->default("");
            $table->string('transaction_date')->nullable()->default("");
            $table->string('is_batch_or_serial')->nullable()->default("");
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
        Schema::dropIfExists('batch_serial_transactions');
    }
}
