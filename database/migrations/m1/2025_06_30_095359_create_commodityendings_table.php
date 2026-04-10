<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommodityendingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commodity_endings', function (Blueprint $table) {
            $table->id();
            $table->integer('commoditybegs_id')->nullable();
            $table->string('document_number')->default("")->nullable();
            $table->integer('stores_id')->nullable();
            $table->integer('customers_id')->nullable();
            $table->string('fiscal_year')->default("")->nullable();
            $table->double('total_cost')->nullable()->default(0);
            $table->double('tax')->nullable()->default(0);
            $table->double('grand_total')->nullable()->default(0);
            $table->string('remark')->default("")->nullable();
            $table->string('status')->default("")->nullable();
            $table->string('last_doc_number')->default("")->nullable();
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
        Schema::dropIfExists('commodity_endings');
    }
}
