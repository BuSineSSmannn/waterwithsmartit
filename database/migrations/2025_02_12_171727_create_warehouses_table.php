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
        Schema::create('warehouses', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('restrict');

            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');      // ID варианта товара
            $table->enum('trx_type',['black','white']);
            $table->decimal('arrival_price',15)->default(0.00); // Цена при поступлении
            $table->decimal('price',15)->default(0.00);
            $table->unsignedInteger('quantity')->default(0);           // Количество товара на складе
            $table->dateTime('date_expire');           // Дата окончания годности товара

            $table->unique(['branch_id','product_id', 'date_expire','price','arrival_price','trx_type'], 'warehouse_unique');

            $table->index(['product_id', 'branch_id']);
            $table->index(['product_id', 'quantity']);
            $table->index(['product_id', 'date_expire']);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
