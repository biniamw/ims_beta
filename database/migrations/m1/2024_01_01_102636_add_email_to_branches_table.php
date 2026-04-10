<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailToBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branches', function (Blueprint $table) {
            //
            $table->string('EmailAddress',"65535")->default('')->nullable()->after('BranchLocation');
            $table->string('PhoneNumber',"65535")->default('')->nullable()->after('EmailAddress');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branches', function (Blueprint $table) {
            //
            $table->dropColumn('EmailAddress');
            $table->dropColumn('PhoneNumber');
        });
    }
}
