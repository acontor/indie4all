<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Listeners\ComprarListener;
use App\Listeners\InvertirListener;
use App\Mail\Compras\CompraRealizada;
use App\Mail\Compras\InversionRealizada;
use App\Models\Campania;
use App\Models\Juego;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
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
        if ($request->tipo == 0) {
            $objetoCompra = Juego::find($request->juegoId);
            $precioCompra = $objetoCompra->precio;

            if ($request->precio != $precioCompra) {
                $status = 0;
                return view('usuario.informePago', ['juego' => $objetoCompra, 'status' => $status]);
            }

            $descripcion = 'Compra del juego ' . $objetoCompra->nombre;
        } else {
            $objetoCompra = Campania::find($request->campaniaId);
            $descripcion = 'Participación en la campaña de' . $objetoCompra->juego->nombre;
        }

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($request->precio);
        $amount->setCurrency('EUR');

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setDescription($descripcion);

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
    }

    public function paypalStatus(Request $request)
    {
        $paymentId = $request->input('paymentId');
        $payerID = $request->input('PayerID');
        $token = $request->input('token');

        if (!$paymentId || !$payerID || !$token) {
            $status = 0;
            return view('usuario.informePago', ['status' => $status]);
        }

        $payment = Payment::get($paymentId, $this->apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId($payerID);

        $result = $payment->execute($execution, $this->apiContext);
        $mensaje = $result->getTransactions();

        if ($result->getState() === 'approved') {
            $status = 1;

            $user = User::find(Auth::id());

            //event(new ComprarListener($user));
            //event(new InvertirListener($user));

            //Mail::to($user->email)->send(new CompraRealizada());
            //Mail::to($user->user()->email)->send(new InversionRealizada());

            return view('usuario.informePago', ['mensaje' => $mensaje, 'status' => $status]);
        }

        $status = 0;

        return view('usuario.informePago', ['status' => $status]);
    }
}
