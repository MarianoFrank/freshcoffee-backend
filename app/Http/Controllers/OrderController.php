<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

            return [
                "message" => "Order added successfully, it will be ready in a few minutes",
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
