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
        Schema::create('stock_invoice_items', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
            $table->unsignedInteger('quantity');
            $table->decimal('price',15)->default(0.00);
            $table->decimal('discount_price', 15, 2)->default(0.00); // Скидка
            $table->decimal('sale_price',15)->default(0.00);
            $table->foreignId('stock_invoice_id')->constrained('stock_invoices')->onDelete('restrict');
            $table->date('date_expire');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_invoice_items');
    }
};
