<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commudities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Zone_Id'); 
            $table->string('Name'); //change to Commodityname
            $table->timestamps();

            $table
                ->foreign('Zone_Id')
                ->references('id')
                ->on('zones')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commudities');
    }
};
