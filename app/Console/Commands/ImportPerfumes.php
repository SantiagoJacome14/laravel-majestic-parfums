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
            $name      = trim((string)($it['name'] ?? ''));

            // Si no viene category, NO lo saltes: pon un default seguro
            $category  = $it['category'] ?? 'arabe'; // arabe/disenador/nicho
            $gender    = $it['gender'] ?? 'unisex';  // hombre/mujer/unisex

            if ($brandName === '' || $name === '') {
                $this->warn("Saltado (faltan campos): " . json_encode($it, JSON_UNESCAPED_UNICODE));
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
            if (!is_array($images)) {
                $images = [];
            }

            /**
             * 🔧 FIX CLAVE:
             * Tu BD tiene UNIQUE(brand_id, name). Si haces updateOrCreate por slug,
             * cuando llegue el mismo perfume (misma marca+nombre) con otro slug,
             * intenta INSERT y revienta.
             *
             * Entonces usamos como "clave" (brand_id, name) para actualizar sin crash.
             */
            Product::updateOrCreate(
                ['brand_id' => $brand->id, 'name' => $name],
                [
                    'slug' => $slug,
                    'category' => $category,
                    'gender' => $gender,
                    'size' => $it['size'] ?? null,
                    'concentration' => $it['concentration'] ?? null,
                    'tag' => $it['tag'] ?? null,
                    'price' => (int)($it['price'] ?? 0),
                    'supplier_price' => isset($it['supplier_price']) ? (int)($it['supplier_price'] ?? 0) : null,
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