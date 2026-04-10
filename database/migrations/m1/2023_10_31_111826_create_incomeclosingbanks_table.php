<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeclosingbanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomeclosingbanks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incomeclosings_id')->constrained();
            $table->foreignId('banks_id')->constrained();
            $table->foreignId('bankdetails_id')->constrained();
            $table->string('SlipNumber')->default("")->nullable();
            $table->double('Amount')->nullable()->default(0);
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
        Schema::dropIfExists('incomeclosingbanks');
    }
}
