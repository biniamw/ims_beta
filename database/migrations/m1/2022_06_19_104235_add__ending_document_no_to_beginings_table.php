<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEndingDocumentNoToBeginingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('beginings', function (Blueprint $table) {
            //
            $table->string('EndingDocumentNo')->nullable()->after('DocumentNumber');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('beginings', function (Blueprint $table) {
            //
            $table->dropColumn('EndingDocumentNo');
        });
    }
}
