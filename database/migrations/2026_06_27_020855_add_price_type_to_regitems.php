<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceTypeToRegitems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('regitems', function (Blueprint $table) {
            //
            $table->string('lot_description')->nullable()->default("")->after('PartNumber');
            $table->double('cartoon_size')->nullable()->default(NULL)->after('lot_description');
            $table->string('price_type')->nullable()->default("")->after('TaxTypeId');
            $table->double('min_price_bt')->nullable()->default(NULL)->after('price_type');
            $table->double('min_price_at')->nullable()->default(NULL)->after('min_price_bt');
            $table->double('default_price_bt')->nullable()->default(NULL)->after('min_price_at');
            $table->double('default_price_at')->nullable()->default(NULL)->after('default_price_bt');
            $table->double('max_price_bt')->nullable()->default(NULL)->after('default_price_at');
            $table->double('max_price_at')->nullable()->default(NULL)->after('max_price_bt');
            $table->string('item_code_mode')->nullable()->default("")->after('oldBarcodeType');
            $table->string('old_item_code')->nullable()->default("")->after('item_code_mode');
            $table->json('item_type')->nullable()->default("")->after('item_code_mode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('regitems', function (Blueprint $table) {
            //
            $table->dropColumn("lot_description");
            $table->dropColumn("cartoon_size");
            $table->dropColumn("price_type");
            $table->dropColumn("min_price_bt");
            $table->dropColumn("min_price_at");
            $table->dropColumn("default_price_bt");
            $table->dropColumn("default_price_at");
            $table->dropColumn("max_price_bt");
            $table->dropColumn("max_price_at");
            $table->dropColumn("item_code_mode");
            $table->dropColumn("old_item_code");
            $table->dropColumn("item_type");
        });
    }
}
