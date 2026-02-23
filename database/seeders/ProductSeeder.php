<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => '9PM',
            'brand' => 'Afnan',
            'slug' => 'afnan-9pm',
            'size' => '100ml',
            'concentration' => 'EDP',
            'tag' => 'Árabe',
            'price' => 175000,
            'supplier_price' => 140000,
            'image' => '/images/perfumes/9pm-Afnan-for-men-perfume-card_compressed.jpg',
            'images' => json_encode([]),
            'stock' => 10,
        ]);

        Product::create([
            'name' => 'Khamrah',
            'brand' => 'Lattafa',
            'slug' => 'lattafa-khamrah',
            'size' => '100ml',
            'concentration' => 'EDP',
            'tag' => 'Árabe',
            'price' => 180000,
            'supplier_price' => 140000,
            'image' => '/images/perfumes/Ajwad-Lattafa-Perfumes-for-women-and-men-perfume-card.jpg',
            'images' => json_encode([]),
            'stock' => 10,
        ]);
    }
}