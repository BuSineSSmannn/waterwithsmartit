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
        Schema::create('products', static function (Blueprint $table) {
            $table->id();          // ID товара
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('restrict');    // ID категории
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('restrict');     // ID поставщика
            $table->string('name');                // Название товара
            $table->string('brand')->nullable();    // Бренд товара
            $table->enum('season', ['spring', 'summer', 'fall', 'winter'])->nullable();  // Сезонность товара
            $table->enum('gender', ['man', 'woman', 'unisex','kids']);      // Пол (мужская, женская, унисекс)
            $table->boolean('is_active')->default(true);  // Активен ли товар для продажи
            $table->string('code', 50)->nullable()->unique();
            $table->integer('sale')->default(0)->unsigned();
            $table->decimal('sell_price', 12, 2)->nullable()->default(0);
            $table->decimal('cost', 12, 2)->nullable()->default(0);
            $table->decimal('profit_percent')->unsigned()->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['category_id', 'supplier_id', 'name'], 'product_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
