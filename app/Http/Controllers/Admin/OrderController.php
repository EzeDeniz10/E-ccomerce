<?php

namespace App\Http\Controllers\Admin; // Verifica la carpeta exacta

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Order; // Importa tu modelo de orden/pedido si lo tienes

class OrderController extends Controller
{
    /**
     * Muestra la lista de órdenes/pedidos.
     */
    public function index()
    {
        // Reemplaza 'Admin.Orders.Index' por la vista que tengas para listar las órdenes
        // Ejemplo: return view('admin.orders.index', compact('orders'));

        return view('admin.orders.index');
    }

    /**
     * Muestra el detalle de una orden en específico.
     */
    public function show(string $id)
    {
        return view('admin.orders.show', compact('id'));
    }
}
