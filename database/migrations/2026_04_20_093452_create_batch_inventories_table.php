<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_inventories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batches_id')->constrained();
            $table->bigInteger('received_qty')->nullable()->default(0);
            $table->bigInteger('sold_issued_qty')->nullable()->default(0);
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
        Schema::dropIfExists('batch_inventories');
    }
}
