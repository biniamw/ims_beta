<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('DocumentNumber')->nullable();
            $table->integer('type')->default(0)->nullable();
            $table->string('PayRangeFrom')->nullable();
            $table->string('PayRangeTo')->nullable();
            $table->string('PreparedBy')->nullable();
            $table->string('PreparedDate')->nullable();
            $table->string('LastEditedBy')->nullable();
            $table->string('LastEditedDate')->nullable();
            $table->string('ApprovedBy')->nullable();
            $table->string('ApprovedDate')->nullable();
            $table->string('RejectBy')->nullable();
            $table->string('RejectDate')->nullable();
            $table->string('UndoRejectBy')->nullable();
            $table->string('UndoRejectDate')->nullable();
            $table->string('VoidBy')->nullable();
            $table->string('VoidDate')->nullable();
            $table->string('VoidReason')->nullable();
            $table->string('UndoVoidBy')->nullable();
            $table->string('UndoVoidDate')->nullable();
            $table->string('Remark')->nullable();
            $table->string('Status')->nullable();
            $table->string('OldStatus')->nullable();
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
        Schema::dropIfExists('payrolls');
    }
}
