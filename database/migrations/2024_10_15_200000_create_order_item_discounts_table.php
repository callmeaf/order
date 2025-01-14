<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_item_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(config('callmeaf-order-item.model'))->constrained()->cascadeOnDelete();
            $table->foreignIdFor(config('callmeaf-voucher.model'))->nullable()->constrained()->nullOnDelete();
            $table->string('type')->nullable();
            $table->string('discount_price')->nullable();
            $table->boolean('is_fixed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_discounts');
    }
};
