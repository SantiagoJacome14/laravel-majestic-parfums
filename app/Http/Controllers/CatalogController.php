<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Inertia\Inertia;

class CatalogController extends Controller
{
    public function index()
    {
        return Inertia::render('Catalog', [
            'products' => Product::query()
                ->select('id','name','brand','slug','price','image','tag','size','concentration')
                ->orderBy('brand')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function show(Product $product)
    {
        return Inertia::render('Product', [
            'product' => $product,
        ]);
    }
}