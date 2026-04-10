<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedbyToAttendanceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attendance_logs', function (Blueprint $table) {
            //
            $table->string('CreatedBy')->default("")->nullable()->after('offshiftstatus');
            $table->string('CreatedDate')->default("")->nullable()->after('CreatedBy');
            $table->string('LastEditedBy')->default("")->nullable()->after('CreatedDate');
            $table->string('LastEditedDate')->default("")->nullable()->after('LastEditedBy');
            $table->string('ChangeToPendingBy')->default("")->nullable()->after('LastEditedDate');
            $table->string('ChangeToPendingDate')->default("")->nullable()->after('ChangeToPendingBy');
            $table->string('ApprovedBy')->default("")->nullable()->after('ChangeToPendingDate');
            $table->string('ApprovedDate')->default("")->nullable()->after('ApprovedBy');
            $table->string('RejectedBy')->default("")->nullable()->after('ApprovedDate');
            $table->string('RejectedDate')->default("")->nullable()->after('RejectedBy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attendance_logs', function (Blueprint $table) {
            //
            $table->dropColumn('CreatedBy');
            $table->dropColumn('CreatedDate');
            $table->dropColumn('LastEditedBy');
            $table->dropColumn('LastEditedDate');
            $table->dropColumn('ChangeToPendingBy');
            $table->dropColumn('ChangeToPendingDate');
            $table->dropColumn('ApprovedBy');
            $table->dropColumn('ApprovedDate');
            $table->dropColumn('RejectedBy');
            $table->dropColumn('RejectedDate');
        });
    }
}
