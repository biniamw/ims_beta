<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegblackListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regblack_lists', function (Blueprint $table) {
            $table->id();
            $table->string('Name')->unique();
            $table->string('Code')->unique();
            $table->string('TinNumber')->unique();
            $table->string('VatNumber')->unique();
            $table->string('PhoneNumber')->unique();
            $table->string('OfficePhone')->unique();
            $table->string('EmailAddress')->unique();
            $table->string('Address');
            $table->string('Website')->unique();
            $table->string('Country');
            $table->string('Memo');
            $table->string('ActiveStatus');
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
        Schema::dropIfExists('regblack_lists');
    }
}
