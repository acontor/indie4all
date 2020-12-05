<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Exception\PayPalConnectionException;
use PayPal\Rest\ApiContext;

class PaymentController extends Controller
{
    private $apiContext;
    public function __construct()
    {
        $payPalConfig =  Config::get('paypal');

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $payPalConfig['client_id'],
                $payPalConfig['secret']
            )
        );
    }

    public function payWithPaypal(Request $request)
    {
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($request->precio);
        $amount->setCurrency('EUR');

        $transaction = new Transaction();
        $transaction->setAmount($amount);

        $url = route('usuario.paypal.status');
        $redirect = new RedirectUrls();
        $redirect->setReturnUrl($url)->setCancelUrl($url);

        $pago = new Payment();
        $pago->setIntent('sale')
            ->setPayer($payer)
            ->setTransactions(array($transaction))
            ->setRedirectUrls($redirect);

        try {
            $pago->create($this->apiContext);
            return redirect()->away($pago->getApprovalLink());
        } catch (PayPalConnectionException $ex) {

            return $ex->getData();
        }
        
        return $request;
    }
    public function paypalStatus(Request $request)
    {

        $paymentId = $request->input('paymentId');
        $payerID = $request->input('PayerID');
        $token = $request->input('token');
        if (!$paymentId || !$payerID || !$token) {
            $mensaje = 'No se pudo procesar el pago, lo sentimos 1';
            return redirect()->route('usuario.juegos.all', ['mensaje' => $mensaje]);
        }
        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerID);

        $result = $payment->execute($execution, $this->apiContext);
        //dd($result);
        if ($result->getState() === 'approved') {
            $mensaje = 'Gracias, el pago ha sido procesado con éxito';
            return redirect()->route('usuario.juegos.all', ['mensaje' => $mensaje]);
        }
        $mensaje = 'No se pudo procesar el pago, lo sentimos 2';
        return redirect()->route('usuario.juegos.all', ['mensaje' => $mensaje]);
    }
}
