<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchInventoriesIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_inventories_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batches_id')->constrained();
            $table->bigInteger('sold_issued_qty')->nullable()->default(0);
            $table->bigInteger('source_id')->nullable()->default(0);
            $table->string('source_type')->nullable()->default("");
            $table->string('status')->nullable()->default("");
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
        Schema::dropIfExists('batch_inventories_issues');
    }
}
