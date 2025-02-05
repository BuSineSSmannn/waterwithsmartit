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
        Schema::create('user_branches', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id2')->constrained('users')->onDelete('restrict');
            $table->foreignId('branch_id')->constrained('branches')->onDelete('restrict');

            $table->unique(['branch_id','user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_branches');
    }
};
