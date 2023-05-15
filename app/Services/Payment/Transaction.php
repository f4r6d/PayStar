<?php

namespace App\Services\Payment;

use App\Exceptions\OrderException;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Cart\Cart;
use Illuminate\Support\Str;

class Transaction
{
    public function __construct(private Cart $cart)
    {
    }

    public function checkout()
    {
        if (! auth()->user()->card_number) {
            throw new OrderException('Please first enter your card number in profile or checkout page..');
        }

        if (! $this->cart->itemCount()) {
            throw new OrderException('Please first add items to your cart..');
        }

        $order = $this->makeOrder();

        $payment = $this->makePayment($order);

        $this->cart->clear();

        return $order;
    }

    private function makeOrder()
    {
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'code' => Str::random(16),
            'amount' => $this->cart->subTotal(),
        ]);

        $order->products()->attach($this->products());

        return $order;
    }

    private function products()
    {
        foreach ($this->cart->all() as $item) {
            $products[$item->id] = ['quantity' => $item->quantity];
        }

        return $products ?? [];
    }

    private function makePayment(Order $order)
    {
        return Payment::create([
            'order_id' => $order->id,
            'payment_amount' => $order->amount,
            'card_number' => auth()->user()->card_number,
        ]);
    }
}
