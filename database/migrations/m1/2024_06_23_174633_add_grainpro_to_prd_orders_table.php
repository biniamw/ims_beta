<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGrainproToPrdOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prd_orders', function (Blueprint $table) {
            //
            $table->string('GrainPro')->default("")->nullable()->after('ContractNumber');
            $table->double('ExportNumofBag')->default(0)->nullable()->after('PrdNetWeight');
            $table->double('ExportWeightbyKg')->default(0)->nullable()->after('ExportNumofBag');
            $table->string('ExportRemark',"65535")->default("")->nullable()->after('ExportWeightbyKg');
            $table->double('RejectNumofBag')->default(0)->nullable()->after('ExportRemark');
            $table->double('RejectWeightbyKg')->default(0)->nullable()->after('RejectNumofBag');
            $table->string('RejectRemark',"65535")->default("")->nullable()->after('RejectWeightbyKg');
            $table->double('WastageNumofBag')->default(0)->nullable()->after('RejectRemark');
            $table->double('WastageWeightbyKg')->default(0)->nullable()->after('WastageNumofBag');
            $table->string('WastageRemark',"65535")->default("")->nullable()->after('WastageWeightbyKg');
            $table->double('StubbleNumofBag')->default(0)->nullable()->after('WastageRemark');
            $table->double('StubbleWeightbyKg')->default(0)->nullable()->after('StubbleNumofBag');
            $table->string('StubbleRemark',"65535")->default("")->nullable()->after('StubbleWeightbyKg');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prd_orders', function (Blueprint $table) {
            //
            $table->dropColumn("GrainPro");
            $table->dropColumn("ExportNumofBag");
            $table->dropColumn("ExportWeightbyKg");
            $table->dropColumn("ExportRemark");
            $table->dropColumn("RejectNumofBag");
            $table->dropColumn("RejectWeightbyKg");
            $table->dropColumn("RejectRemark");
            $table->dropColumn("WastageNumofBag");
            $table->dropColumn("WastageWeightbyKg");
            $table->dropColumn("WastageRemark");
            $table->dropColumn("StubbleNumofBag");
            $table->dropColumn("StubbleWeightbyKg");
            $table->dropColumn("StubbleRemark");
        });
    }
}
