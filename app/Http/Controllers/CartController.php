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

    public function index()
    {
        $items = $this->cart->all();
        return view('cart.cart', ['items' => $items]);
    }

    public function add(Product $product)
    {
        try {
            $this->cart->add($product, 1);
        } catch (OrderException $e) {
            return back()->with([
                'msg' => $e->getMessage(),
                'title' => 'Error',
            ]);
        }

        return back()->with([
            'msg' => 'added to your cart',
            'title' => $product->name,
        ]);
    }

    public function remove(Product $product)
    {
        try {
            $this->cart->remove($product);
        } catch (OrderException $e) {
            return back()->with([
                'msg' => $e->getMessage(),
                'title' => 'Error',
            ]);
        }

        return back()->with([
            'msg' => 'removed from your cart',
            'title' => $product->name,
        ]);
    }

    public function update(Product $product)
    {
        
        $quantity = request()->quantity;
        try {
            $this->cart->update($product, $quantity);
        } catch (OrderException $e) {
            return back()->with([
                'msg' => $e->getMessage(),
                'title' => 'Error',
            ]);
        }

        return back()->with([
            'msg' => 'quantity updated',
            'title' => $product->name,
        ]);
    }

    public function clear()
    {
        if (!$this->cart->itemCount()) {
            return back()->with([
                'msg' => 'Cart is already empty',
                'title' => 'Warning',
            ]);
        }

        $this->cart->clear();
        return back()->with([
            'msg' => 'Items removed from your cart',
            'title' => 'Info',
        ]);
    }

    public function checkoutForm()
    {
        if (!$this->cart->itemCount()) {
            return to_route('home')->with([
                'msg' => 'Please first add items to your cart..',
                'title' => 'Error',
            ]);
        }

        $items = $this->cart->all();

        return view('cart.checkout', ['items' => $items]);
    }

    public function checkout()
    {
        try {
            $result = $this->transaction->checkout();
        } catch (OrderException $e) {

            return back()->with([
                'msg' => $e->getMessage(),
                'title' => 'Error',
            ]);
        }

        if ($result['status'] == 1) {
            return to_route('dashboard')->with([
                'msg' => "The order {$result['payment']->order->id} was placed..",
                'title' => 'Success',
            ]);
        } else {
            return back()->with([
                'msg' => 'Error in payment.....',
                'title' => 'Error',
            ]);
        }
    }
}
