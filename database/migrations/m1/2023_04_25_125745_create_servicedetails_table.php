<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicedetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicedetails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('services_id')->constrained();
            $table->foreignId('groupmembers_id')->constrained();
            $table->foreignId('paymentterms_id')->constrained();
            $table->foreignId('periods_id')->constrained();
            $table->double('MemberPrice')->nullable()->default(0);
            $table->double('NewMemberPrice')->nullable()->default(0);
            $table->double('Discount')->nullable()->default(0);
            $table->string('Description')->nullable();
            $table->string('Status');
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
        Schema::dropIfExists('servicedetails');
    }
}
