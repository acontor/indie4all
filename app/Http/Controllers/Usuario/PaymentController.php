<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Listeners\ComprarListener;
use App\Listeners\InvertirListener;
use App\Mail\Compras\CompraRealizada;
use App\Mail\Compras\InversionRealizada;
use App\Models\Campania;
use App\Models\Compra;
use App\Models\Juego;
use App\Models\User;
use Carbon\Carbon;
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
        $this->middleware('auth');

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

            $descripcion = 'Compra del juego ' . $objetoCompra->nombre . '. ' . $objetoCompra->id;
        } else {
            $objetoCompra = Campania::find($request->campaniaId);
            $descripcion = 'Participación en la campaña de' . $objetoCompra->juego->nombre .  '. ' . $objetoCompra->id;
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

        if ($result->getState() === 'approved') {
            $user = User::find(Auth::id());
            $status = 1;
            $mensaje = $result->getTransactions();
            $tipo = $mensaje[0]->description;
            $tipo = explode(' ', $tipo);
            $id =  array_pop($tipo);
            foreach ($mensaje as $item) {
                $precio =  $item->amount->total;
                $dateTime = Carbon::parse($request->your_datetime_field);
            }
            if ($tipo[0] == 'Compra') {

                Compra::create([
                    'precio' => $precio,
                    'key' => 'ramdomkey',
                    'fecha_compra' => $dateTime->format('Y-m-d H:i:s'),
                    'user_id' => Auth::id(),
                    'juego_id' => $id,
                ]);
                event(new ComprarListener($user));
                Mail::to($user->email)->send(new CompraRealizada());
            } else {
                $participacion = Compra::where('user_id', Auth::id())->where('campania_id', $id)->get();
                if ($participacion->count() == 0) {
                    Compra::create([
                        'precio' => $precio,
                        'key' => 'ramdomkey',
                        'fecha_compra' => $dateTime->format('Y-m-d H:i:s'),
                        'user_id' => Auth::id(),
                        'campania_id' => $id,
                    ]);
                } else {
                    $participacion = Compra::find($participacion[0]->id);
                    $participacion->precio += $precio;
                    $participacion->save();
                }

                $campania = Campania::find($id);
                $campania->recaudado += $precio;
                $campania->save();

                event(new InvertirListener($user));
                Mail::to($user->email)->send(new InversionRealizada());
            }

            return view('usuario.informePago', ['mensaje' => $mensaje, 'status' => $status]);
        }

        $status = 0;

        return view('usuario.informePago', ['status' => $status]);
    }
}
