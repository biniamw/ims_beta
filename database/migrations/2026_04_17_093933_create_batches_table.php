<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->integer('source_id')->nullable()->default(0);
            $table->integer('brand_id')->nullable()->default(0);
            $table->integer('model_id')->nullable()->default(0);
            $table->integer('item_id')->nullable()->default(0);
            $table->string('batch_number')->nullable()->default("");
            $table->string('manufacturing_date')->nullable()->default("");
            $table->string('expiry_date')->nullable()->default("");
            $table->string('status')->nullable()->default("");
            $table->string('uuid')->nullable()->default("");
            $table->string('is_temp')->nullable()->default("");
            $table->string('source_type')->nullable()->default("");
            $table->string('remark')->nullable()->default("");
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
        Schema::dropIfExists('batches');
    }
}
