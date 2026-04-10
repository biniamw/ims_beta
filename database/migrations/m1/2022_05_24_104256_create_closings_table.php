<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClosingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('closings', function (Blueprint $table) {
            $table->id();
            $table->string('DocumentNumber')->unique();
            $table->integer('store_id')->default(0);
            $table->string('FiscalYear');
            $table->string('Username');
            $table->string('Status');
            $table->string('CalendarType');
            $table->string('Memo');
            $table->string('Common');
            $table->string('CountedBy');
            $table->string('CountedDate');
            $table->string('VerifiedBy');
            $table->string('VerifiedDate');
            $table->string('PostedBy');
            $table->string('PostedDate');
            $table->string('AdjustedBy');
            $table->string('AdjustedDate');
            $table->string('Date');
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
        Schema::dropIfExists('closings');
    }
}
