<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrdOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prd_orders', function (Blueprint $table) {
            $table->id();
            $table->string('ProductionOrderNumber')->nullable();
            $table->string('CompanyType')->nullable();
            $table->foreignId('customers_id')->constrained();
            $table->string('RepName',"65535")->nullable();
            $table->string('RepPhone',"65535")->nullable();
            $table->string('OutputType')->default("")->nullable();
            $table->foreignId('prd_bomchildren_id');
            $table->double('ExpectedAmount')->nullable();
            $table->foreignId('woredas_id')->constrained();
            $table->string("Grade")->nullable();
            $table->string("ProcessType")->nullable();
            $table->string("CommodityType")->nullable();
            $table->string("Symbol")->nullable();
            $table->string("OrderDate")->nullable();
            $table->string("Deadline")->nullable();
            $table->string("ProductionStartDate")->nullable();
            $table->string("ProductionEndDate")->nullable();
            $table->string("ContractNumber")->nullable();
            $table->string("SieveSize")->nullable();
            $table->string("CGrade")->nullable();
            $table->string("ThickCoffee")->nullable();
            $table->string('FrontSideBagLabel',"65535")->nullable();
            $table->string('BackSideBagLabel',"65535")->nullable();
            $table->string('AdditionalInstruction',"65535")->nullable();
            $table->foreignId('users_id')->constrained();
            $table->string("AdditionalFile")->nullable();
            $table->string('Remark',"65535")->nullable();
            $table->integer('CurrentDocumentNumber')->default(0)->nullable();
            $table->string("Status")->nullable();
            $table->string("OldStatus")->nullable();
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
        Schema::dropIfExists('prd_orders');
    }
}
