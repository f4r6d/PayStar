<?php

namespace App\Http\Controllers;

use App\Exceptions\OrderException;
use App\Services\Payment\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private Transaction $transaction)
    {
    }

    public function verify()
    {
        try {
            $result = $this->transaction->verify();
        } catch (OrderException $e) {
            return to_route('dashboard')->with([
                'msg' => $e->getMessage(),
                'title' => 'Error',
            ]);
        }

        if ($result['status'] == 1) {
            return to_route('dashboard')->with([
                'msg' => "The order {$result['payment']->order->id} was placed, Payment successfully paid..",
                'title' => 'success',
            ]);
        } else {
            return to_route('dashboard')->with([
                'msg' => "Error in payment.....",
                'title' => 'Error',
            ]);
        }
    }
}
