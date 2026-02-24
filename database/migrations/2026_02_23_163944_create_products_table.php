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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Relación con marcas
            $table->foreignId('brand_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();

            // Clasificación
            $table->enum('category', ['arabe', 'disenador', 'nicho'])->index();
            $table->enum('gender', ['hombre', 'mujer', 'unisex'])->default('unisex')->index();

            // Detalles
            $table->string('size')->nullable();          // 100ml
            $table->string('concentration')->nullable(); // EDP, EDT
            $table->string('tag')->nullable();           // bestseller, nuevo

            // Precios
            $table->unsignedInteger('price');
            $table->unsignedInteger('supplier_price')->nullable();

            // Imágenes
            $table->string('image')->nullable(); // principal
            $table->json('images')->nullable();  // galería

            // Inventario
            $table->unsignedInteger('stock')->default(10);

            // Estados
            $table->boolean('is_new')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Evita duplicados por marca
            $table->unique(['brand_id', 'name']);
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