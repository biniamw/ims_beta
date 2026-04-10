<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoyaltystatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loyaltystatuses', function (Blueprint $table) {
            $table->id();
            $table->string('LoyalityStatus')->nullable()->default("");
            $table->double('MinDay')->nullable()->default(0);
            $table->double('MaxDay')->nullable()->default(0);
            $table->double('Discount')->nullable()->default(0);
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
        Schema::dropIfExists('loyaltystatuses');
    }
}
