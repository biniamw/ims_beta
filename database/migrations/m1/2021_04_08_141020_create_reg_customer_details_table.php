<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegCustomerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reg_customer_details', function (Blueprint $table) {
            $table->id();
            $table->integer('CustomerId');
            $table->string('CustomerName');
            $table->string('MRCNumber')->unique();
            $table->string('IsTemp');
            $table->integer('IsDeleted')->unique();
            $table->string('MachineName')->unique();
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
        Schema::dropIfExists('reg_customer_details');
    }
}
