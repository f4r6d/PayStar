<?php

namespace App\Services\Payment\Gateway;

use App\Models\Payment;
use Illuminate\Http\Request;

interface GatewayInterface
{
    public function pay(Payment $payment);
    public function verify(Request $request);
}
