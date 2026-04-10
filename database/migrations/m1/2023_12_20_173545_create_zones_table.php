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
        Schema::create('zones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Rgn_Id');
            $table->string('Zone_Name')->unique();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->text('description')->nullable();
            $table->string('status');
            $table->timestamps();

            $table
                ->foreign('Rgn_Id')
                ->references('id')
                ->on('regions')
                ->onDelete('cascade');
            $table
                ->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table
                ->foreign('updated_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zones');
    }
};
