<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_leaves', function (Blueprint $table) {
            $table->id();
            $table->string('LeaveID')->default("")->nullable();
            $table->foreignId('hr_leavetypes_id')->constrained();
            $table->string('RequestedDate')->nullable();
            $table->string('LeaveFrom')->nullable();
            $table->string('LeaveTo')->nullable();
            $table->integer('NumberOfDays')->nullable();
            $table->unsignedBigInteger('requested_for')->unsigned();
            $table->unsignedBigInteger('prepared_by')->unsigned();
            $table->unsignedBigInteger('approved_by')->unsigned();
            $table->unsignedBigInteger('rejected_by')->unsigned();
            $table->unsignedBigInteger('lastedited_by')->unsigned();
            $table->unsignedBigInteger('supervisor')->unsigned();
            $table->unsignedBigInteger('void_by')->unsigned();
            $table->unsignedBigInteger('undovoid_by')->unsigned();
            $table->unsignedBigInteger('commented_by')->unsigned();
            $table->foreign('supervisor')->references('id')->on('users');
            $table->foreign('prepared_by')->references('id')->on('users');
            $table->string('PreparedDate')->nullable();
            $table->foreign('approved_by')->references('id')->on('users');
            $table->string('ApprovedDate')->nullable();
            $table->string('ApproveNote',"65535")->nullable();
            $table->foreign('rejected_by')->references('id')->on('users');
            $table->string('RejectedDate')->nullable();
            $table->string('RejectReason',"65535")->nullable();
            $table->foreign('commented_by')->references('id')->on('users');
            $table->string('CommentDate')->nullable();
            $table->string('Comment',"65535")->nullable();
            $table->foreign('void_by')->references('id')->on('users');
            $table->string('VoidDate')->nullable();
            $table->string('VoidReason',"65535")->nullable();
            $table->foreign('undovoid_by')->references('id')->on('users');
            $table->string('UndoVoidDate')->nullable();
            $table->foreign('lastedited_by')->references('id')->on('users');
            $table->string('LastEditedDate')->nullable();
            $table->string('Remark',"65535")->nullable();
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
        Schema::dropIfExists('hr_leaves');
    }
}
