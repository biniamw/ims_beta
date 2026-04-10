<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProformalogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proformalogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proforma_id')->constrained();
            $table->string('status')->nullable();
            $table->date('Date')->nullable();
            $table->date('Expiredate')->nullable();
            $table->date('Extendedate')->nullable();
            $table->integer('extenday')->nullable()->default(0);
            $table->string('username')->nullable();
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
        Schema::dropIfExists('proformalogs');
    }
}
