<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLookuprefsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lookuprefs', function (Blueprint $table) {
            $table->id();
            $table->integer('Type')->nullable();
            $table->string('LookupName')->nullable();
            $table->integer('Status')->nullable();
            $table->string('Description',"65535")->nullable();
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
        Schema::dropIfExists('lookuprefs');
    }
}
