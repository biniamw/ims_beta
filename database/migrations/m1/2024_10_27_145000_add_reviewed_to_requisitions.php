<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReviewedToRequisitions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            //
            $table->string('ReviewedBy')->default("")->nullable()->after('AuthorizedDate');
            $table->string('ReviewedDate')->default("")->nullable()->after('ReviewedBy');
            $table->string('DispatchStatus')->default("")->nullable()->after('Status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            //
            $table->dropColumn("ReviewedBy");
            $table->dropColumn("ReviewedDate");
            $table->dropColumn("DispatchStatus");
        });
    }
}
