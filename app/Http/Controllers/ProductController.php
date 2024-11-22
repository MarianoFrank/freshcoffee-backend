<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Helpers\NumberHelper;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // Iniciar la consulta base
        $query = Product::query();

        if (!auth()->user()->admin) {
            //si no es admin solo traemos los disponibles, al admin se le mostrarán todos
            $query->where('available', true);
        }

        // Filtrar por categoría si se proporciona el parámetro 'category_id'
        if (!is_null($request->query('category_id'))) {
            $categoryId = intval($request->query('category_id'));
            if ($categoryId > 0) {
                $query->where('category_id', $categoryId);
            }
        }

        return new ProductCollection($query->get());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        try {
            $product->available = $request->available;
            $product->save();
            return response()->json(
                [
                    'message' => 'Product updated successfully',
                    'product' => $product->id
                ],
                200
            );
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
    public function destroy(string $id)
    {
        //
    }
}
