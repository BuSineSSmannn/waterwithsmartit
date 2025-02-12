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
        Schema::create('warehouse_invoice_items', static function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
            $table->unsignedInteger('quantity');
            $table->decimal('arrival_price',15)->default(0.00);
            $table->decimal('discount_price', 15)->default(0.00); // Скидка
            $table->decimal('price',15)->default(0.00);
            $table->foreignId('warehouse_invoice_id')->constrained('warehouse_invoices')->onDelete('restrict');
            $table->date('date_expire');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_invoice_items');
    }
};
