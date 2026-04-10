<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDevicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branches_id')->constrained();
            $table->string('DeviceId')->default("")->nullable();
            $table->string('DeviceName')->default("")->nullable();
            $table->string('IpAddress')->default("")->nullable();
            $table->string('Port')->default("")->nullable();
            $table->string('TimeZone')->default("")->nullable();
            $table->string('SyncMode')->default("")->nullable();
            $table->string('RegistrationDevice')->default("")->nullable();
            $table->string('AttendanceDevice')->default("")->nullable();
            $table->string('Username')->default("")->nullable();
            $table->string('Password')->default("")->nullable();
            $table->string('Description',"65535")->default("")->nullable();
            $table->string('CreatedBy')->default("")->nullable();
            $table->string('LastEditedBy')->default("")->nullable();
            $table->string('LastEditedDate')->default("")->nullable();
            $table->string('Status')->default("")->nullable();
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
        Schema::dropIfExists('devices');
    }
}
