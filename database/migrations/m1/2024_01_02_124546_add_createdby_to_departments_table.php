<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedbyToDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            //
            $table->foreignId('departments_id')->default(1)->constrained()->after('id');
            $table->string('CreatedBy',"65535")->default('')->nullable()->after('Description');
            $table->string('LastEditedBy',"65535")->default('')->nullable()->after('CreatedBy');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departments', function (Blueprint $table) {
            //
            $table->dropColumn('departments_id');
            $table->dropColumn('CreatedBy');
            $table->dropColumn('LastEditedBy');
        });
    }
}
