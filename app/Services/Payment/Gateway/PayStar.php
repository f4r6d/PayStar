<?php

namespace App\Services\Payment\Gateway;

use Exception;
use App\Exceptions\OrderException;
use App\Models\Payment;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use SoapClient;

class PayStar  implements GatewayInterface
{
    public function pay(Payment $payment)
    {
        $token = $this->getToken($payment);
        $redirect_url = config('services.paystar.baseURI') . 'payment';
        $this->redirectToBank($redirect_url, $token);
    }

    private function redirectToBank(string $redirect_url, string $token)
    {
        echo "<form id='bank' action='{$redirect_url}' method='post'>
        <input type='hidden' name='token' value='{$token}'>
        </form><script>document.forms['bank'].submit()</script>";
    }


    public function verify(Request $request)
    {
        // check if payment has done
        if ($request->status != 1) {
            throw new OrderException('Error in payment..');
        }

        // find payment by ref_num from bank post response
        $ref_num = $request->ref_num;
        try {
            $payment = Payment::where('ref_num', $ref_num)->firstOrFail();
        } catch (\Throwable $th) {
            throw new OrderException('Error in payment..');
        }

        // save transaction_id into the database
        $payment->transaction_id = $request->transaction_id;
        $payment->save();

        
        // format card number for checking if user has paid the order by his/her card number
        $card_number = $payment->card_number;
        $card_number = substr_replace($card_number, str_repeat("*", 6), 6, 6);
        
        
        
        if ($card_number != $request->card_number) {
            throw new OrderException('You should pay the order with the given card number in profile..');
        }
        
        // get ready data to send verify reauest
        $amount = $payment->payment_amount;
        $tracking_code = $request->tracking_code;

        $sign = hash_hmac(
            'SHA512',
            $amount . '#' . $ref_num . '#' . $card_number . '#' . $tracking_code,
            config('services.paystar.secretKey')
        );

        $data = [
            'ref_num' => $ref_num,
            'amount' => $amount,
            'sign' => $sign,
        ];

        // get verify response 
        $response = $this->sendRequestVerify($data);

        // update payment database
        if ($response->status == 1) {
            $payment->status = 1;
            $payment->tracking_code = $tracking_code;
            $payment->save();
        }

        return $response;
    }



    private function getToken(Payment $payment)
    {
        $amount = $payment->payment_amount;
        $order_id = $payment->order->code;
        $card_number = $payment->card_number;
        $callback = config('services.paystar.callback');
        $sign = hash_hmac(
            'SHA512',
            $amount . '#' . $order_id . '#' . $callback,
            config('services.paystar.secretKey')
        );

        $data = [
            'amount' => $amount,
            'order_id' => $order_id,
            'callback' => $callback,
            'sign' => $sign,
            'card_number' => $card_number,
        ];

        $response = $this->sendRequestToken($data);

        $ref_num = $response->data->ref_num;
        $payment->ref_num = $ref_num;
        $payment->save();

        return $response->data->token;
    }


    private function sendRequestToken(array $data)
    {
        $client = new Client;

        try {
            $response = $client->post(config('services.paystar.baseURI') . 'create', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . config('services.paystar.gatewayId'),
                ],
                'json' => $data
            ]);
        } catch (Exception $e) {
            throw new OrderException('Error in Payment, try again..');
        }

        return json_decode($response->getBody());
    }

    private function sendRequestVerify(array $data)
    {
        $client = new Client;

        try {

            $response = $client->post(config('services.paystar.baseURI') . 'verify', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . config('services.paystar.gatewayId'),
                    'Keep-Alive' => 'timeout=15, max=1000',
                ],
                'json' => $data
            ]);
        } catch (Exception $e) {
            throw new OrderException('Error in verify Payment, your money will back in 72hours..');
        }

        return json_decode($response->getBody());
    }
}
