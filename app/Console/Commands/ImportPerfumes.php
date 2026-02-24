<?php

namespace App\Console\Commands;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ImportPerfumes extends Command
{
    protected $signature = 'perfumes:import {--path= : Path al JSON (default: database/seeders/data/products.json)}';
    protected $description = 'Importa perfumes desde un JSON y crea brands/products automáticamente.';

    public function handle(): int
    {
        $path = $this->option('path') ?: database_path('seeders/data/products.json');

        if (!file_exists($path)) {
            $this->error("No existe el archivo: {$path}");
            return self::FAILURE;
        }

        $items = json_decode(file_get_contents($path), true);
        if (!is_array($items)) {
            $this->error("El JSON no es válido o no es un array.");
            return self::FAILURE;
        }

        $count = 0;

        foreach ($items as $it) {
            $brandName = trim((string)($it['brand'] ?? ''));
            $name = trim((string)($it['name'] ?? ''));
            $category = $it['category'] ?? null; // arabe/disenador/nicho
            $gender = $it['gender'] ?? 'unisex'; // hombre/mujer/unisex

            if ($brandName === '' || $name === '' || !$category) {
                $this->warn("Saltado (faltan campos): " . json_encode($it));
                continue;
            }

            // Crear/obtener marca
            $brand = Brand::firstOrCreate(
                ['slug' => Str::slug($brandName)],
                ['name' => $brandName]
            );

            // Slug del producto
            $slug = $it['slug'] ?? Str::slug($brandName . ' ' . $name . ' ' . ($it['size'] ?? ''));

            // Normaliza imágenes
            $images = $it['images'] ?? [];
            if (!is_array($images)) $images = [];

            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'brand_id' => $brand->id,
                    'name' => $name,
                    'category' => $category,
                    'gender' => $gender,
                    'size' => $it['size'] ?? null,
                    'concentration' => $it['concentration'] ?? null,
                    'tag' => $it['tag'] ?? null,
                    'price' => (int)($it['price'] ?? 0),
                    'supplier_price' => isset($it['supplier_price']) ? (int)$it['supplier_price'] : null,
                    'image' => $it['image'] ?? null,
                    'images' => $images,
                    'stock' => (int)($it['stock'] ?? 0),
                    'is_new' => (bool)($it['is_new'] ?? false),
                    'is_active' => (bool)($it['is_active'] ?? true),
                ]
            );

            $count++;
        }

        $this->info("✅ Importados/actualizados: {$count} perfumes");
        return self::SUCCESS;
    }
}