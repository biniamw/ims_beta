<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prd_boms', function (Blueprint $table) {
            $table->id();
            $table->string("BomName");
            $table->string("type")->nullable();
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
        Schema::dropIfExists('boms');
    }
}
