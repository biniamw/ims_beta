<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentPathToApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            //
            $table->string('DocumentOriginalName',"65535")->nullable()->after('Memo');
            $table->string('DocumentUploadPath',"65535")->nullable()->after('DocumentOriginalName');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            //
            $table->dropColumn('DocumentOriginalName');
            $table->dropColumn('DocumentUploadPath');
        });
    }
}
