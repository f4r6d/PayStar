<?php

namespace App\Services\Cart;

use App\Models\Product;
use App\Services\Cart\Contracts\CartInterface;

class Cart
{
    public function __construct(private CartInterface $cart)
    {
    }

    public function add(Product $product, int $quantity)
    {
        if ($this->has($product)) {
            $quantity = $this->get($product)['quantity'] + $quantity;
        }

        $this->cart->put($product->id, [
            'quantity' => $quantity,
        ]);
    }

    public function has(Product $product)
    {
        return $this->cart->has($product->id);
    }

    public function get(Product $product)
    {
        return $this->cart->get($product->id);
    }

    public function itemCount()
    {
        return $this->cart->count();
    }

    public function all()
    {
        $items = Product::find(array_keys($this->cart->all()));

        foreach ($items as $item) {
            $item->quantity = $this->get($item)['quantity'];
        }

        return $items;
    }

    public function subTotal()
    {
        $total = 0;
        foreach ($this->all() as $item) {
            $total += $item->price * $item->quantity;
        }

        return $total;
    }

    public function clear()
    {
        $this->cart->clear();
    }
}
