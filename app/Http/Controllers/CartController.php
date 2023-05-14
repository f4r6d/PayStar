<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private Cart $cart)
    {
        $this->middleware('auth')->only('checkout');
    }

    public function add(Product $product)
    {
        $this->cart->add($product, 1);

        return back()->with([
            'success' => 'added to your cart',
            'item' => $product->name,
        ]);
    }

    public function index()
    {
        $items = $this->cart->all();
        return view('cart.cart', ['items'=> $items]);
    }

    public function checkout()
    {
        return view('cart.checkout');
    }

    public function clear()
    {
        $this->cart->clear();
        return back();
    }
}
