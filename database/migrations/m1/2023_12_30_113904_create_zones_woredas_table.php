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
        Schema::create('zones_woredas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('zones_id')->unsigned();
            $table->unsignedBiginteger('woredas_id')->unsigned();

            $table
                ->foreign('zones_id')
                ->references('id')
                ->on('zones')
                ->onDelete('cascade');
            $table
                ->foreign('woredas_id')
                ->references('id')
                ->on('woredas')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zones_woredas');
    }
};
