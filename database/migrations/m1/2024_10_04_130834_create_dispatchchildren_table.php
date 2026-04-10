<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispatchchildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatchchildren', function (Blueprint $table) {
            $table->id();
            $table->string('ReqDetailId')->default()->nullable();
            $table->foreignId('dispatchparents_id')->constrained();
            $table->double('NumOfBag')->default(0)->nullable();
            $table->double('TotalKG')->default(0)->nullable();
            $table->double('NetKG')->default(0)->nullable();
            $table->string('Remark')->default()->nullable();
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
        Schema::dropIfExists('dispatchchildren');
    }
}
