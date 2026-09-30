<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    // Listado de todas las órdenes
    public function index()
    {
        // Traemos las órdenes ordenadas de la más reciente a la más vieja
        $orders = Order::latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    // Detalle de una orden específica
    public function show(int $id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

   public function updateStatus(Request $request, string $id)
{
    $request->validate([
        'status' => 'required|in:pendiente,enviado,entregado,cancelado',
    ]);

    $order = Order::findOrFail($id);
    $order->update(['status' => $request->status]);

    return redirect()->back()->with('success', 'Estado actualizado correctamente.');
}
}
