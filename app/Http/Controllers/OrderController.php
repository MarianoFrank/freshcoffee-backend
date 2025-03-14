<?php

namespace App\Http\Controllers;

use App\Events\NewOrder;
use App\Events\OrderComplete;
use App\Http\Resources\OrderCollection;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // Obtener los parámetros de la URL
        $status = $request->query('status', 'pending'); // pending por default
        $orderBy = $request->query('orderBy', 'asc'); // valor por defecto 'asc'
        $recently = $request->query('recently', false); // 'false' por defecto



        // Filtrar por estado si existe el parámetro
        $query = Order::query();

        // Si el parámetro 'recently' es true, filtrar las órdenes de las últimas 3 horas
        if ($recently) {
            $threeHoursAgo = now()->subHours(3); // Obtener la fecha y hora de hace 3 horas
            $query->where('updated_at', '>=', $threeHoursAgo); // Filtrar por 'updated_at' desde hace 3 horas
        }

        if ($status === 'completed') {
            $query->where("state", 1); // 1 representa completado, ajusta según tu lógica
        } elseif ($status === 'pending') {
            $query->where("state", 0);
        }



        // Ordenar según el parámetro orderBy
        $query->orderBy('updated_at', $orderBy);

        // Incluir relaciones
        $orders = $query->with('products:id,name,category_id')
            ->with('user:id,name')
            ->get();

        return new OrderCollection($orders);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            //crear pedido
            $order = new Order();
            $order->user_id = auth()->id();
            $order->total = $request->total;
            $order->save();

            //relacionar los productos en la tabla pivot
            $products = $request->products;

            foreach ($products as $product) {
                $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
            }

            //emitir evento (trasmitir a todos los usuarios conectados al canal, excepto al que lo envia)
            event(new NewOrder($order->with("products:id,name,category_id")->with("user:id,name")->find($order->id)));

            return [
                "message" => "Order added successfully, it will be ready in a few minutes",
                "order_id" => $order->id
            ];
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'error' =>  "An error has occurred, please try again in a few moments",
                ],
                500
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        try {
            $order->state = 1; //estado 1 completado
            $order->save();
            //emitir evento (trasmitir a todos los usuarios conectados al canal, excepto al que lo envia)
            event(new OrderComplete($order->with("products:id,name,category_id")->with("user:id,name")->find($order->id)));
            return [
                "message" => "Order completed successfully",
                "order" => $order->id
            ];
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'error' =>  "An error has occurred, please try again in a few moments",
                ],
                500
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
