<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrLeaveTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_leave_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('HeaderId');
            $table->integer('employees_id');
            $table->integer('hr_leavetypes_id');
            $table->string('Year')->nullable()->default("");
            $table->double('LeaveEarned')->nullable()->default(0);
            $table->double('LeaveUsage')->nullable()->default(0);
            $table->string('Remark')->nullable()->default("");
            $table->string('RecordType')->nullable()->default("");
            $table->string('ReferenceNumber')->nullable()->default("");
            $table->string('Date')->nullable()->default("");
            $table->integer('BaseHeaderId')->nullable()->default(0);
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
        Schema::dropIfExists('hr_leave_transactions');
    }
}
