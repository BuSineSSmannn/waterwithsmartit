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
        Schema::create('stock', static function (Blueprint $table) {
            $table->bigIncrements('id');                   // Уникальный ID записи
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');      // ID варианта товара
            $table->enum('trx_type',['black','white']);
            $table->unsignedInteger('quantity');           // Количество товара на складе
            $table->dateTime('expiration_date');           // Дата окончания годности товара
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['product_id','expiration_date'], 'stock_unique');

            $table->index(['product_id', 'white_quantity']);
            $table->index(['product_id', 'black_quantity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock');
    }
};
