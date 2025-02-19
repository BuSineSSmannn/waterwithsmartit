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
        Schema::create('warehouse_movements', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('restrict');
            $table->foreignId('warehouse_id')->constrained('warehouses')->onDelete('restrict');
            $table->foreignId('invoice_id')->nullable(); // ID накладной
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict');
            $table->enum('type', ['arrival', 'departure', 'transfer', 'return']); // Указываем фиксированные значения
            $table->decimal('purchase_price', 15); // Закупочная цена
            $table->integer('quantity');
            $table->text('description')->nullable();

            $table->timestamps();

            $table->index(['invoice_id', 'created_at']);
            $table->index(['branch_id', 'created_at']);
            $table->index(['warehouse_id', 'invoice_id']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_movements');
    }
};
