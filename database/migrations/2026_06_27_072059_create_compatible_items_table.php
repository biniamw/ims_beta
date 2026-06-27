<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompatibleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compatible_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('base_item_id')
                  ->nullable()
                  ->constrained('regitems')
                  ->onDelete('set null')
                  ->onUpdate('cascade');
            $table->foreignId('compatible_item_id')
                ->nullable()
                ->constrained('regitems')
                ->onDelete('set null')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('compatible_items');
    }
}
