<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('item_id')
                ->nullable()
                ->constrained('regitems')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('supplier_id')
                ->nullable()
                ->constrained('customers')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreignId('uom_id')
                ->nullable()
                ->constrained('uoms')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->double('quantity')->nullable()->default(NULL);
            $table->double('price')->nullable()->default(NULL);
            $table->string('availability')->nullable()->default("");
            $table->string('remark')->nullable()->default("");
            $table->string('status')->nullable()->default("");
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
        Schema::dropIfExists('item_suppliers');
    }
}
