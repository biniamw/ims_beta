<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispatchparentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatchparents', function (Blueprint $table) {
            $table->id();
            $table->string('ReqId')->default()->nullable();
            $table->string('DispatchDocNo')->default()->nullable();
            $table->string('DispatchMode')->default()->nullable();
            $table->string('DriverName')->default()->nullable();
            $table->string('DriverLicenseNo')->default()->nullable();
            $table->string('DriverPhoneNo')->default()->nullable();
            $table->string('PlateNumber')->default()->nullable();
            $table->string('ContainerNumber')->default()->nullable();
            $table->string('PersonName')->default()->nullable();
            $table->string('PersonPhoneNo')->default()->nullable();
            $table->string('Date')->default()->nullable();
            $table->string('Remark')->default()->nullable();
            $table->string('PreparedBy')->default("")->nullable();
            $table->string('PreparedDate')->default("")->nullable();
            $table->string('VerifiedBy')->default("")->nullable();
            $table->string('VerifiedDate')->default("")->nullable();
            $table->string('ApprovedBy')->default("")->nullable();
            $table->string('ApprovedDate')->default("")->nullable();
            $table->string('ReceivedBy')->default("")->nullable();
            $table->string('CurrentDocumentNumber')->default()->nullable();
            $table->string('Status')->default()->nullable();
            $table->string('OldStatus')->default()->nullable();
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
        Schema::dropIfExists('dispatchparents');
    }
}
