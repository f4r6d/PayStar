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
            return to_route('dashboard')->with('msg', $e->getMessage());
        }
        
        if ($result) {
            return to_route('dashboard')->with('msg', "ُThe order was placed, Payment successfully paid..");
        }
    }
}
