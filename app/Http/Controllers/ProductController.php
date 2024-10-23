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

        // Filtrar por disponibilidad si se proporciona el parámetro 'available'
        if (!is_null($request->query('available'))) {
            $query->where('available', NumberHelper::toBoolean($request->query('available')));
        }

        // Filtrar por categoría si se proporciona el parámetro 'category_id'
        if (!is_null($request->query('category_id'))) {
            $categoryId = intval($request->query('category_id'));
            if ($categoryId > 0) {
                $query->where('category_id', $categoryId);
            }
        }
        // Devolver la colección de productos paginada
        return new ProductCollection($query->paginate(env('RESOURCES_PER_PAGE', 10)));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
