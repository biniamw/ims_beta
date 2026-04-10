<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employes', function (Blueprint $table) {
            $table->id();
            $table->string('EmployeeId')->nullable();
            $table->foreignId('departments_id')->constrained();
            $table->string('Name')->nullable();
            $table->string('Gender')->nullable();
            $table->string('DOB')->nullable();
            $table->string('TinNumber')->nullable();
            $table->string('Nationality')->nullable();
            $table->string('Country')->nullable();
            $table->integer('cities_id')->unsigned();
            $table->integer('subcities_id')->unsigned();
            $table->string('Woreda')->nullable();
            $table->string('Location')->nullable();
            $table->string('Mobile')->nullable();
            $table->string('Phone')->nullable();
            $table->string('Email')->nullable();
            $table->string('Occupation')->nullable();
            $table->string('IdentificationId')->nullable();
            $table->string('ResidanceId')->nullable();
            $table->string('PassportNo')->nullable();
            $table->string('HealthStatus')->nullable();
            $table->string('Memo')->nullable();
            $table->string('Picture')->nullable();
            $table->string('Status',100)->nullable();
            $table->string('EmergencyName')->nullable();
            $table->string('EmergencyMobile')->nullable();
            $table->string('EmergencyLocation')->nullable();
            $table->timestamps();
            //$table->foreign('cities_id')->references('id')->on('cities');
            //$table->foreign('subcities_id')->references('id')->on('subcities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employes');
    }
}
