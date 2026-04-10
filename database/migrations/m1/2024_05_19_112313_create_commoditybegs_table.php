<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommoditybegsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commoditybegs', function (Blueprint $table) {
            $table->id();
            $table->string("DocumentNumber",)->nullable();
            $table->string("EndingDocumentNumber",)->nullable();
            $table->foreignId('stores_id')->constrained();
            $table->string("FiscalYear")->nullable();
            $table->double('TotalPrice')->default(0)->nullable();
            $table->double('Tax')->default(0)->nullable();
            $table->double('GrandTotal')->default(0)->nullable();
            $table->string("Remark","65535")->nullable();
            $table->string("Status",)->nullable();
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
        Schema::dropIfExists('commoditybegs');
    }
}
