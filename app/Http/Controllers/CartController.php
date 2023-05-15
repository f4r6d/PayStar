<?php

namespace App\Http\Controllers;

use App\Exceptions\OrderException;
use App\Models\Product;
use App\Services\Cart\Cart;
use App\Services\Payment\Transaction;

class CartController extends Controller
{
    public function __construct(private Cart $cart, private Transaction $transaction)
    {
        $this->middleware('auth')->only('checkoutForm', 'checkout');
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
        return view('cart.cart', ['items' => $items]);
    }

    public function clear()
    {
        $this->cart->clear();
        return back();
    }

    public function checkoutForm()
    {
        if (!$this->cart->itemCount()) {
            return to_route('products.index')->with('success', 'Please first add items to your cart..');
        }

        return view('cart.checkout');
    }

    public function checkout()
    {
        try {
            $order = $this->transaction->checkout();
        } catch (OrderException $e) {
            
            return back()->with('success', $e->getMessage());
        }

        return to_route('dashboard')->with('success', "order {$order->id} has been done");
    }
}
