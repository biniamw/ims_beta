<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('employees_id')->nullable()->default(0);
            $table->integer('type')->nullable()->default(0);
            $table->string('doc_date')->nullable()->default("");
            $table->string('sign_date')->nullable()->default("");
            $table->string('expire_date')->nullable()->default("");
            $table->integer('duration')->nullable()->default(0);
            $table->string('doc_name')->nullable()->default("");
            $table->string('actual_file_name')->nullable()->default("");
            $table->string('remark')->nullable()->default("");
            $table->string('upload_type')->nullable()->default("");
            $table->string('description')->nullable()->default("");
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
        Schema::dropIfExists('employee_documents');
    }
}
