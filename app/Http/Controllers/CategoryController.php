<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        //esto no hace falta porque laravel serializa las colecciones y modelos automaticamente a JSON
       // return response()->json(Category::all());
       return Category::all();
    }
}
