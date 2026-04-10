<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceImportLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_import_logs', function (Blueprint $table) {
            $table->id();
            $table->string('RecordId')->nullable();
            $table->integer('empid')->default(0)->nullable();
            $table->string('Name')->nullable();
            $table->string('DateTime')->nullable();
            $table->integer('deviceid')->default(0)->nullable();
            $table->string('DeviceCode')->nullable();
            $table->double('similarity1')->default(0)->nullable();
            $table->double('similarity2')->default(0)->nullable();
            $table->string('ImportType')->nullable();
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
        Schema::dropIfExists('attendance_import_logs');
    }
}
