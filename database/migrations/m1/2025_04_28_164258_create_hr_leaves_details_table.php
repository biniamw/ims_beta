<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrLeavesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_leaves_details', function (Blueprint $table) {
            $table->id();
            $table->integer('hr_leaves_id');
            $table->integer('hr_leavetypes_id');
            $table->string('Year')->nullable()->default("");
            $table->string('LeavePaymentType')->nullable()->default("");
            $table->string('RequireBalance')->nullable()->default("");
            $table->double('NumberOfDays')->nullable()->default(0);
            $table->string('Remark')->nullable()->default("");
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
        Schema::dropIfExists('hr_leaves_details');
    }
}
