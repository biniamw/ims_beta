<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApptrainersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apptrainers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applications_id')->constrained();
            $table->foreignId('memberships_id')->constrained();
            $table->foreignId('services_id')->constrained();
            $table->foreignId('periods_id')->constrained();
            $table->foreignId('employes_id')->constrained();
            $table->double('BeforeTotal')->nullable()->default(0);
            $table->double('Tax')->nullable()->default(0);
            $table->double('TotalAmount')->nullable()->default(0);
            $table->double('DiscountServicePercent')->nullable()->default(0);
            $table->double('DiscountServiceAmount')->nullable()->default(0);
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
        Schema::dropIfExists('apptrainers');
    }
}
