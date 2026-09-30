<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use MercadoPago\Client\Payment\PaymentClient;

class CheckoutController extends Controller
{
    // Mostrar formulario de Checkout
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('success', 'Tu carrito está vacío, no podés hacer el checkout.');
        }

        return view('checkout.index', compact('cart'));
    }

    // Procesar la compra y redirigir a Mercado Pago
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('admin.products.index');
        }

        // Validación de los datos del cliente
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'customer_email' => 'required|email|max:255',
            'address'        => 'required|string|max:255',
            'city'           => 'required|string|max:255',
        ]);

        // Calculamos el total
        $total = 0;
        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        $order = null;

        // 1. Guardar Orden e Ítems en la Base de Datos
        DB::transaction(function () use ($request, $cart, $total, &$order) {
            $order = Order::create([
                'customer_name'  => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_email' => $request->customer_email,
                'address'        => $request->address,
                'city'           => $request->city,
                'total_amount'   => $total,
                'status'         => 'pending',
            ]);

            foreach ($cart as $productId => $details) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $productId,
                    'quantity'   => $details['quantity'],
                    'price'      => $details['price'],
                ]);

                // Descontar stock del producto
                $product = Product::find($productId);
                if ($product) {
                    $product->decrement('stock', $details['quantity']);
                }
            }
        });

        if (!$order) {
            return redirect()->route('cart.index')->with('error', 'Hubo un problema al procesar el pedido.');
        }

        // 2. Configurar Mercado Pago
        $accessToken = config('services.mercadopago.access_token') ?? env('MERCADOPAGO_ACCESS_TOKEN');

        if (!$accessToken) {
            return redirect()->back()->with('error', 'Error de configuración: No se encontró el Access Token de Mercado Pago.');
        }

        MercadoPagoConfig::setAccessToken($accessToken);

        // Cargar ítems para la preferencia de MP
        $orderWithItems = Order::with('items.product')->find($order->id);
        $itemsMP = [];

        foreach ($orderWithItems->items as $item) {
            $itemsMP[] = [
                'id'          => (string) $item->product_id,
                'title'       => (string) ($item->product->name ?? 'Producto'),
                'quantity'    => (int) $item->quantity,
                'unit_price'  => (float) $item->price,
                'currency_id' => 'ARS',
            ];
        }

        // 3. Crear Preferencia en Mercado Pago
        try {
        $client = new PreferenceClient();
            $preference = $client->create([
                'items' => $itemsMP,
                'payer' => [
                    'name'  => (string) $order->customer_name,
                    'email' => (string) $order->customer_email,
                ],
                'back_urls' => [
                    'success' => route('checkout.success', $order->id),
                    'failure' => route('checkout.failure', $order->id),
                    'pending' => route('checkout.pending', $order->id),
                ],
                'external_reference' => (string) $order->id,

                // Webhook / Notificación de Mercado Pago (usa APP_URL en producción)
                'notification_url' => route('mercadopago.webhook'),
            ]);
            // Vaciar carrito
            session()->forget('cart');

            // Determinar si redirigir a sandbox o producción
            $redirectUrl = str_contains($accessToken, 'TEST-')
                ? ($preference->sandbox_init_point ?? $preference->init_point)
                : $preference->init_point;

            return redirect($redirectUrl);

        } catch (MPApiException $e) {
            Log::error('Error MercadoPago API: ' . json_encode($e->getApiResponse()->getContent()));
            return redirect()->back()->with('error', 'Error de Mercado Pago: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('Error general Checkout: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error inesperado al conectar con Mercado Pago.');
        }
    }

    // Pantalla de pago con éxito
    public function success(int $id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        $order->update(['status' => 'paid']);

        return view('checkout.success', compact('order'));
    }

    // Pantalla de pago fallido
    public function failure(int $id)
    {
        $order = Order::findOrFail($id);
        return view('checkout.failure', compact('order'));
    }

    // Pantalla de pago pendiente
    public function pending(int $id)
    {
        $order = Order::findOrFail($id);
        return view('checkout.pending', compact('order'));
    }
    // Recibir notificaciones IPN / Webhooks de Mercado Pago
    public function webhook(Request $request)
    {
        // 1. Loguear los datos recibidos para debugging
        Log::info('Webhook de Mercado Pago recibido:', $request->all());

        // Mercado Pago puede enviar la notificación por 'type' o por 'topic'
        $type = $request->input('type') ?? $request->input('topic');
        $paymentId = $request->input('data.id') ?? $request->input('id');

        if ($type === 'payment' && $paymentId) {
            try {
                // Configurar Access Token
                $accessToken = config('services.mercadopago.access_token') ?? env('MERCADOPAGO_ACCESS_TOKEN');
                MercadoPagoConfig::setAccessToken($accessToken);

                // Consultar el estado del pago en la API de Mercado Pago
                $paymentClient = new PaymentClient();
                $payment = $paymentClient->get($paymentId);

                // Obtener el ID de la orden guardado en 'external_reference'
                $orderId = $payment->external_reference;

                if ($orderId) {
                    $order = Order::find($orderId);

                    if ($order) {
                        if ($payment->status === 'approved') {
                            $order->update(['status' => 'paid']);
                            Log::info("Orden #{$orderId} actualizada a 'paid' exitosamente.");
                        } elseif ($payment->status === 'rejected') {
                            $order->update(['status' => 'rejected']);
                            Log::info("Orden #{$orderId} marcada como 'rejected'.");
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error('Error procesando Webhook MP: ' . $e->getMessage());
                return response()->json(['error' => $e->getMessage()], 500);
            }
        }

        // Responder siempre a MP con 200 OK para que sepa que la notificación fue recibida
        return response()->json(['status' => 'ok'], 200);
    }
}
