<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->integer('record_id')->nullable()->default(0);
            $table->string('record_type')->nullable()->default("");
            $table->integer('document_type')->nullable()->default(0);
            $table->string('date')->nullable()->default("");
            $table->string('doc_name')->nullable()->default("");
            $table->string('actual_file_name')->nullable()->default("");
            $table->string('remark')->nullable()->default("");
            $table->string('status')->nullable()->default("");
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
        Schema::dropIfExists('documents');
    }
}
