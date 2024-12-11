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
        Schema::create('suppliers', static function (Blueprint $table) {
            $table->id();
            $table->string('name',200);
            $table->string('phone_number',32)->nullable();
            $table->string('email',255)->nullable();
            $table->string('address',255)->nullable();
            $table->string('slug',255)->nullable();
            $table->enum('status',['active', 'inactive'])->default('active');
            $table->decimal('balance',15)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
