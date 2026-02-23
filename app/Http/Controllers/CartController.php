<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartController extends Controller
{
    private function getCart(Request $request): array
    {
        return $request->session()->get('cart', []); // [productId => qty]
    }

    private function saveCart(Request $request, array $cart): void
    {
        $request->session()->put('cart', $cart);
    }

    public function index(Request $request)
    {
        $cart = $this->getCart($request);
        $ids = array_keys($cart);

        $products = Product::whereIn('id', $ids)->get()->map(function ($p) use ($cart) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'brand' => $p->brand,
                'slug' => $p->slug,
                'price' => $p->price,
                'image' => $p->image,
                'qty' => $cart[$p->id] ?? 1,
            ];
        })->values();

        $total = $products->sum(fn($p) => $p['price'] * $p['qty']);

        return Inertia::render('Cart', [
            'items' => $products,
            'total' => $total,
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['nullable','integer','min:1','max:99']
        ]);

        $qty = $data['qty'] ?? 1;
        $cart = $this->getCart($request);
        $cart[$data['product_id']] = ($cart[$data['product_id']] ?? 0) + $qty;

        $this->saveCart($request, $cart);

        return back();
    }

    public function remove(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer']
        ]);

        $cart = $this->getCart($request);
        unset($cart[$data['product_id']]);
        $this->saveCart($request, $cart);

        return back();
    }

    public function clear(Request $request)
    {
        $this->saveCart($request, []);
        return back();
    }

    public function checkout(Request $request)
    {
        $cart = $this->getCart($request);
        $ids = array_keys($cart);

        $items = Product::whereIn('id', $ids)->get()->map(function ($p) use ($cart) {
            $qty = $cart[$p->id] ?? 1;
            return "{$qty}x {$p->brand} {$p->name} ({$p->price})";
        })->values()->all();

        $message = "Hola! Quiero hacer este pedido:\n\n" . implode("\n", $items);

        return Inertia::render('Checkout', [
            'message' => $message,
            // pon tu número aquí en formato internacional
            'whatsapp' => '57TU_NUMERO_AQUI',
        ]);
    }
}