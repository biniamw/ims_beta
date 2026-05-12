<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_orders', function (Blueprint $table) {
            $table->id();
            $table->string('document_number')->nullable()->default("");
            $table->bigInteger('reference_type')->nullable()->default(0);
            $table->bigInteger('reference_id')->nullable()->default(0);
            $table->string('product_type')->nullable()->default("");
            $table->bigInteger('station')->nullable()->default(0);
            $table->text('delivery_date')->nullable()->default("");
            $table->text('expiry_date')->nullable()->default("");
            $table->string('order_by')->nullable()->default("");
            $table->string('sales_person')->nullable()->default("");
            $table->string('supporting_doc_no')->nullable()->default("");
            $table->string('payment_type')->nullable()->default("");
            $table->string('payment_term')->nullable()->default("");
            $table->boolean('show_pricing')->nullable()->default(false);
            $table->bigInteger('customers_id')->nullable()->default(1);
            $table->string('delivery_by')->nullable()->default("");
            $table->string('phone_no')->nullable()->default("");
            $table->string('id_no')->nullable()->default("");
            $table->string('plate_no')->nullable()->default("");
            $table->double('total_price')->nullable()->default(0);
            $table->integer('fiscal_year')->nullable()->default(0);
            $table->bigInteger('current_document_no')->nullable()->default(0);
            $table->string('prepared_by')->nullable()->default("");
            $table->text('prepared_date')->nullable()->default("");
            $table->string('verified_by')->nullable()->default("");
            $table->text('verified_date')->nullable()->default("");
            $table->string('approved_by')->nullable()->default("");
            $table->text('approved_date')->nullable()->default("");
            $table->string('remark')->nullable()->default("");
            $table->string('status')->nullable()->default("");
            $table->string('status_old')->nullable()->default("");
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
        Schema::dropIfExists('delivery_orders');
    }
}
