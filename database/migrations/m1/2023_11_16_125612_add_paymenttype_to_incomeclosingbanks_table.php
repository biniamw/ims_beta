<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymenttypeToIncomeclosingbanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incomeclosingbanks', function (Blueprint $table) {
            //
            $table->string('PaymentType')->default("")->nullable()->after('incomeclosings_id');
            $table->string('SlipDate')->default("")->nullable()->after('SlipNumber');
            $table->string('Remark')->default("")->nullable()->after('Amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incomeclosingbanks', function (Blueprint $table) {
            //
            $table->dropColumn('PaymentType');
            $table->dropColumn('SlipDate');
            $table->dropColumn('Remark');
        });
    }
}
