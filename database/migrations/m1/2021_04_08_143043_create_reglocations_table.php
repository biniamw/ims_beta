<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReglocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reglocations', function (Blueprint $table) {
            $table->id();
            $table->integer('StoreId');
            $table->string('LocationName');
            $table->string('ActiveStatus');
            $table->string('IsTemp');
            $table->integer('IsDeleted')->unique();
            $table->string('MachineName')->unique();
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
        Schema::dropIfExists('reglocations');
    }
}
