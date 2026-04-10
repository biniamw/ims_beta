<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrdStorageFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prd_storage_fees', function (Blueprint $table) {
            $table->id();
            $table->integer('CommType')->default(0)->nullable();
            $table->double('MinDateAmount')->default(0)->nullable();
            $table->double('MaxDateAmount')->default(0)->nullable();
            $table->double('Amount')->default(0)->nullable();
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
        Schema::dropIfExists('prd_storage_fees');
    }
}
