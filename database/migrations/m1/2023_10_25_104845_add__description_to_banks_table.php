<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDescriptionToBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('banks', function (Blueprint $table) {
            //
            $table->string('Description')->nullable()->after('BankName');
            $table->string('CreatedBy')->nullable()->after('Status');
            $table->string('CreatedDate')->nullable()->after('CreatedBy');
            $table->string('LastEditedBy')->nullable()->after('CreatedDate');
            $table->string('LastEditedDate')->nullable()->after('LastEditedBy');
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
        Schema::table('banks', function (Blueprint $table) {
            //
            $table->dropColumn('Description');
            $table->dropColumn('CreatedBy');
            $table->dropColumn('CreatedDate');
            $table->dropColumn('LastEditedBy');
            $table->dropColumn('LastEditedDate');
        });
    }
}
