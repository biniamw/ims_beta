<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmpcolumnsToEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            //
            $table->string('title')->nullable()->after('id')->default("");
            $table->string('kebele')->nullable()->after('Woreda')->default("");
            $table->string('house_no')->nullable()->after('kebele')->default("");
            $table->string('blood_type')->nullable()->after('MartialStatus')->default("");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            //
            $table->dropColumn("title");
            $table->dropColumn("kebele");
            $table->dropColumn("house_no");
            $table->dropColumn("blood_type");
        });
    }
}
