<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDsBeginingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dsbeginings', function (Blueprint $table) {
            $table->id();
            $table->string('DocumentNumber')->nullable();
            $table->string('EndingDocumentNo')->nullable();
            $table->integer('StoreId')->nullable()->default(0);
            $table->string('FiscalYear')->nullable();
            $table->string('Username')->nullable();
            $table->string('Status')->nullable();
            $table->string('CalendarType')->nullable();
            $table->string('Memo')->nullable();
            $table->string('Common')->nullable();
            $table->string('CountedBy')->nullable();
            $table->date('CountedDate')->nullable();
            $table->string('VerifiedBy')->nullable();
            $table->date('VerifiedDate')->nullable();
            $table->string('PostedBy')->nullable();
            $table->date('PostedDate')->nullable();
            $table->string('AdjustedBy')->nullable();
            $table->date('AdjustedDate')->nullable();
            $table->date('Date')->nullable();
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
        Schema::dropIfExists('dsbeginings');
    }
}
