<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegitemdetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regitemdetails', function (Blueprint $table) {
            $table->id();
            $table->integer('ItemId');
            $table->string('FileName');
            $table->string('ContentType');
            $table->string('ImageData');
            $table->integer('IsDeleted')->unique();
            $table->string('MachineName')->unique();
            $table->string('IsTemp')->unique();
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
        Schema::dropIfExists('regitemdetails');
    }
}
