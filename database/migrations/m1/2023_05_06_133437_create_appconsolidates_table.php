<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppconsolidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appconsolidates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applications_id')->constrained();
            $table->foreignId('memberships_id')->constrained();
            $table->foreignId('services_id')->constrained();
            $table->foreignId('periods_id')->constrained();
            $table->string('RegistrationDate')->nullable();
            $table->string('ExpiryDate')->nullable();
            $table->string('FreezeRegistrationDate')->nullable();
            $table->string('FreezeExpiryDate')->nullable();
            $table->string('FreezedBy')->nullable();
            $table->string('FreezedDate')->nullable();
            $table->string('UnFreezedBy')->nullable();
            $table->string('UnFreezedDate')->nullable();
            $table->integer('ExtendDay')->nullable()->default(0);
            $table->integer('RemainingDay')->nullable()->default(0);
            $table->string('Status',100)->nullable();
            $table->string('OldStatus',100)->nullable();
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
        Schema::dropIfExists('appconsolidates');
    }
}
