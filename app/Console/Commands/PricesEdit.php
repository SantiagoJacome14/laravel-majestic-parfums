<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class PricesEdit extends Command
{
    protected $signature = 'prices:edit
        {--category= : Filtra por category (arabe|disenador|nicho)}
        {--gender= : Filtra por gender (hombre|mujer|unisex)}
        {--search= : Buscar por texto en nombre o marca}
        {--only-missing : Solo productos con price = 0}
        {--limit= : Limita cantidad a editar}
    ';

    protected $description = 'Editar precios manualmente (y corregir género/categoría) producto por producto.';

    public function handle(): int
    {
        $q = Product::query()->with('brand');

        if ($cat = $this->option('category')) {
            $q->where('category', $cat);
        }

        if ($gen = $this->option('gender')) {
            $q->where('gender', $gen);
        }

        if ($this->option('only-missing')) {
            $q->where('price', 0);
        }

        if ($search = $this->option('search')) {
            $q->where(function ($qq) use ($search) {
                $qq->where('name', 'like', "%{$search}%")
                   ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$search}%"));
            });
        }

        $q->orderByRaw('brand_id asc')->orderBy('name');

        if ($limit = $this->option('limit')) {
            $q->limit((int) $limit);
        }

        $products = $q->get();

        if ($products->isEmpty()) {
            $this->warn('No hay productos para editar con esos filtros.');
            return self::SUCCESS;
        }

        $this->info("Encontrados: {$products->count()} productos.");
        $this->line("Comandos durante la edición:");
        $this->line("  Enter = mantener precio | número = nuevo precio");
        $this->line("  s = saltar | q = salir | g = cambiar género | c = cambiar categoría | a = auto-guess género");
        $this->newLine();

        $edited = 0;

        foreach ($products as $p) {
            $brand = $p->brand?->name ?? 'Sin marca';
            $label = "{$brand} - {$p->name}";
            $this->line(str_repeat('-', 70));
            $this->info($label);

            $this->line("ID: {$p->id} | slug: {$p->slug}");
            $this->line("category: {$p->category} | gender: {$p->gender} | size: " . ($p->size ?? '-'));
            $this->line("supplier_price: " . ($p->supplier_price ?? 0) . " | price(actual): " . ($p->price ?? 0));
            $this->line("activo: " . ($p->is_active ? 'sí' : 'no') . " | stock: " . ($p->stock ?? 0));

            while (true) {
                $ans = $this->ask("Nuevo precio (Enter=igual / s / q / g / c / a)");

                if ($ans === null || $ans === '') {
                    // mantener
                    break;
                }

                $ans = trim((string)$ans);

                if (strtolower($ans) === 'q') {
                    $this->warn("Saliendo. Editados: {$edited}");
                    return self::SUCCESS;
                }

                if (strtolower($ans) === 's') {
                    // saltar
                    break;
                }

                if (strtolower($ans) === 'g') {
                    $newGender = $this->choice('Género', ['hombre', 'mujer', 'unisex'], 2);
                    $p->gender = $newGender;
                    $p->save();
                    $this->info("✅ Género actualizado a: {$newGender}");
                    continue;
                }

                if (strtolower($ans) === 'c') {
                    $newCat = $this->choice('Categoría', ['arabe', 'disenador', 'nicho'], 0);
                    $p->category = $newCat;
                    $p->save();
                    $this->info("✅ Categoría actualizada a: {$newCat}");
                    continue;
                }

                if (strtolower($ans) === 'a') {
                    $guess = $this->guessGender($brand, $p->name);
                    $p->gender = $guess;
                    $p->save();
                    $this->info("✅ Auto-guess género: {$guess}");
                    continue;
                }

                // número
                $num = preg_replace('/[^\d]/', '', $ans);
                if ($num === '') {
                    $this->warn("Entrada inválida. Usa un número, Enter, s, q, g, c o a.");
                    continue;
                }

                $newPrice = (int) $num;
                $p->price = $newPrice;
                $p->save();

                $edited++;
                $this->info("✅ Precio actualizado a: {$newPrice}");
                break;
            }
        }

        $this->info("✅ Terminado. Precios editados: {$edited}");
        return self::SUCCESS;
    }

    private function guessGender(string $brand, string $name): string
    {
        $t = Str::upper($brand . ' ' . $name);

        // Mujer
        if (
            Str::contains($t, ['POUR FEMME', 'FEMME', 'WOMAN', 'FOR HER', 'POUR ELLE', 'DAM', 'DAMA', 'GIRL', 'MUJER'])
        ) {
            return 'mujer';
        }

        // Hombre
        if (
            Str::contains($t, ['POUR HOMME', 'HOMME', 'FOR HIM', 'MEN', 'MAN', 'CABALLERO', 'HOMBRE', 'BOY'])
        ) {
            return 'hombre';
        }

        return 'unisex';
    }
}