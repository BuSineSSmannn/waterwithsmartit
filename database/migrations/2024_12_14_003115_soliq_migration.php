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
        Schema::create('product_groups', static function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->string('code',50);

            $table->index('name');
        });

        Schema::create('product_classifications', static function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->string('code',50);

            $table->index('name');
        });

        Schema::create('product_positions', static function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->string('code',50);

            $table->index('name');
        });

        Schema::create('product_suppositions', static function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->string('code',50);

            $table->index('name');
        });

        Schema::create('product_brands', static function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->string('code',50);

            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_groups');
        Schema::dropIfExists('product_classifications');
        Schema::dropIfExists('product_positions');
        Schema::dropIfExists('product_suppositions');
        Schema::dropIfExists('product_brands');
    }
};
