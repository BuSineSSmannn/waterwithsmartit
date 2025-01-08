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
            $table->decimal('arrival_price',15)->default(0.00); // Цена при поступлении
            $table->decimal('price',15)->default(0.00);
            $table->unsignedInteger('quantity')->default(0);           // Количество товара на складе
            $table->dateTime('date_expire');           // Дата окончания годности товара

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['product_id','date_expire'], 'stock_unique');

            $table->index(['product_id', 'quantity']);
            $table->index(['product_id', 'date_expire']);
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
