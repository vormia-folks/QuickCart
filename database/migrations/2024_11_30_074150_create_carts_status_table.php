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
        Schema::create('carts_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart')->constrained('carts')->onDelete('cascade');
            $table->string('action')->nullable()->default(null);
            $table->string('description')->nullable()->default(null);
            $table->integer('flag')->default(1);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts_status');
    }
};
