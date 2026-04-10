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
        Schema::create('woredas', function (Blueprint $table) {
            $table->id();
            $table->string('Woreda_Name')->unique();
            $table->string('Wh_name')->unique();
            $table->unsignedBigInteger('zone_id');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->text('description')->nullable();
            $table->string('status');
            $table->timestamps();
            $table
                ->foreign('zone_id')
                ->references('id')
                ->on('zones')
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
        Schema::dropIfExists('woredas');
    }
};
