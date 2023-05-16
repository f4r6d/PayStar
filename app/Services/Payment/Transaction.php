<?php

namespace App\Services\Payment;

use App\Exceptions\OrderException;
use App\Models\Order;
use App\Models\Payment;
use App\Services\Cart\Cart;
use App\Services\Payment\Gateway\PayStar;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Transaction
{
    public function __construct(private Request $request, private Cart $cart, private PayStar $gateway)
    {
    }

    public function checkout()
    {
        if (!auth()->user()->card_number) {
            throw new OrderException('Please first enter your card number in profile or checkout page..');
        }

        if (!$this->cart->itemCount()) {
            throw new OrderException('Please first add items to your cart..');
        }

        DB::beginTransaction();
        try {

            $order = $this->makeOrder();
            $payment = $this->makePayment($order);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return null;
        }

        // for zero payments don't go to gateway
        if ($payment->payment_amount) {
            // pay the payment
            $this->gateway->pay($payment);

        } else {

            // set product as paid for zero amount orders
            $payment->status = 1;
            $payment->save();
            
            $this->normalizeQuantity($payment);

            $this->cart->clear();

            return [
                'status' => 1,
                'payment' => $payment,
            ];
        }

    }

    private function normalizeQuantity(Payment $payment)
    {
        foreach ($payment->order->products as $product){
            $product->decrementStock($product->detail->quantity);
        }
    }


    public function verify()
    {
        $result = $this->gateway->verify($this->request);
     

        if ($result['status'] == 1) {

            // set product as paid and save tracking_code in database
            $payment = $result['payment'];
            $payment->status = 1;
            $payment->tracking_code = $result['tracking_code'];
            $payment->save();

            $this->normalizeQuantity($payment);

            $this->cart->clear();

        }

        return [
            'status' => $result['status'],
            'payment' => $payment,
        ];
    }

    private function makeOrder()
    {
        $order = Order::create([
            'user_id' => auth()->user()->id,
            'code' => Str::random(16),
            'amount' => $this->cart->subTotal(),
        ]);

        $order->products()->attach($this->orderProducts());

        return $order;
    }

    private function orderProducts()
    {
        foreach ($this->cart->all() as $item) {
            $orderProducts[$item->id] = ['quantity' => $item->quantity];
        }

        return $orderProducts ?? [];
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
