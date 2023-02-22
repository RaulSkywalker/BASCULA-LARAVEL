<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cart_invoice', function (Blueprint $table) {
            $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('invoice_id');

            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');

            $table->unique(['cart_id', 'invoice_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_invoice');
    }
};
