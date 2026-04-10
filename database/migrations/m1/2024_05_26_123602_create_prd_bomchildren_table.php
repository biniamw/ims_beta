<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrdBomchildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prd_bomchildren', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prd_boms_id')->constrained();
            $table->string("BomChildName");
            $table->double('TotalCost')->default(0)->nullable();
            $table->string("Description","65535")->nullable();
            $table->string("Status")->nullable();
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
        Schema::dropIfExists('prd_bomchildren');
    }
}
