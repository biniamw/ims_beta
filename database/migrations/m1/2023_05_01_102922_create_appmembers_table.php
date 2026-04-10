<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppmembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appmembers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applications_id')->constrained();
            $table->foreignId('memberships_id')->constrained();
            $table->string('RegistrationDate')->nullable();
            $table->string('ExpiryDate')->nullable();
            $table->string('IsMemberBefore')->nullable();
            $table->string('Status')->nullable();
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
        Schema::dropIfExists('appmembers');
    }
}
