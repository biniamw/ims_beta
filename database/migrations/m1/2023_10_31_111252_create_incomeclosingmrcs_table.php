<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeclosingmrcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomeclosingmrcs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('incomeclosings_id')->constrained();
            $table->string('MrcNumber')->default("")->nullable();
            $table->string('ZNumber')->default("")->nullable();
            $table->string('ZDate')->default("")->nullable();
            $table->double('CashAmount')->nullable()->default(0);
            $table->double('CreditAmount')->nullable()->default(0);
            $table->double('TotalAmount')->nullable()->default(0);
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
        Schema::dropIfExists('incomeclosingmrcs');
    }
}
