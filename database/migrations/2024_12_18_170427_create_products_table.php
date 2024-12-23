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
            $table->id();
            $table->foreignId('product_group_id')->nullable()->constrained('product_groups')->onDelete('restrict');
            $table->foreignId('product_classification_id')->nullable()->constrained('product_classifications')->onDelete('restrict');
            $table->foreignId('product_position_id')->nullable()->constrained('product_positions')->onDelete('restrict');
            $table->foreignId('product_supposition_id')->nullable()->constrained('product_suppositions')->onDelete('restrict');
            $table->foreignId('product_brand_id')->nullable()->constrained('product_brands')->onDelete('restrict');
            $table->string('name')->nullable(); // Атрибут
            $table->string('mxik_code')->nullable(); // MXIK CODE
            $table->string('mxik_name')->nullable(); // MXIK NAME
            $table->string('barcode')->nullable(); // Штрих код
            $table->string('measuring_group')->nullable(); // ИЗМЕРИТЕЛЬНАЯ ГРУППА
            $table->string('unit')->nullable(); // Единица измерения
            $table->string('packaging')->nullable(); // Упаковка
            $table->enum('status',['active', 'inactive'])->default('active');
            $table->enum('is_imported',['0', '1'])->default('0');
            $table->decimal('price',15)->default(0.00);
            $table->timestamps();
            $table->softDeletes();

            $table->index('name');
            $table->index('mxik_code');
            $table->index('mxik_name');
            $table->index('barcode');
            $table->index('measuring_group');
            $table->index('unit');
            $table->index('packaging');

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
