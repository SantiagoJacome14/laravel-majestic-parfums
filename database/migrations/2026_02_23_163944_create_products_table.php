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
        $table->string('name');
        $table->string('brand');
        $table->string('slug')->unique();
        $table->string('size')->nullable();
        $table->string('concentration')->nullable();
        $table->string('tag')->nullable();
        $table->integer('price');
        $table->integer('supplier_price')->nullable();
        $table->string('image')->nullable();
        $table->json('images')->nullable();
        $table->integer('stock')->default(10);
        $table->timestamps();
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
