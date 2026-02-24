<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $category = $request->query('category'); // arabe/disenador/nicho
        $gender = $request->query('gender');     // hombre/mujer/unisex

        $products = Product::query()
            ->with(['brand:id,name,slug'])
            ->where('is_active', true)
            ->when($category, fn ($query) => $query->where('category', $category))
            ->when($gender, fn ($query) => $query->where('gender', $gender))
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('name', 'like', "%{$q}%")
                        ->orWhere('tag', 'like', "%{$q}%")
                        ->orWhereHas('brand', fn ($b) => $b->where('name', 'like', "%{$q}%"));
                });
            })
            ->select('id','brand_id','name','slug','category','gender','price','image','tag','size','concentration','stock','is_new')
            ->orderByDesc('is_new')
            ->orderBy('name')
            ->paginate(24)
            ->withQueryString();

        return Inertia::render('Catalog', [
            'products' => $products,
            'filters' => [
                'q' => $q,
                'category' => $category,
                'gender' => $gender,
            ],
        ]);
    }

    public function show(Product $product)
    {
        $product->load('brand:id,name,slug');

        return Inertia::render('Product', [
            'product' => $product,
        ]);
    }
}