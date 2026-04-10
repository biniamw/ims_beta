<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reg_customers', function (Blueprint $table) {
            $table->id();
            $table->string('Name')->unique();
            $table->string('Code')->unique();
            $table->string('Type')->unique();
            $table->string('TinNumber')->unique();
            $table->string('VatNumber')->unique();
            $table->string('MRCNumber')->unique();
            $table->string('VatType')->unique();
            $table->string('Witholding')->unique();
            $table->string('PhoneNumber')->unique();
            $table->string('OfficePhone')->unique();
            $table->string('EmailAddress')->unique();
            $table->string('Address');
            $table->string('Website')->unique();
            $table->string('Country');
            $table->string('Memo');
            $table->string('ActiveStatus');
            $table->string('Reason');
            $table->string('IsDeleted');
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
        Schema::dropIfExists('reg_customers');
    }
}
