<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|unique:categorias,nome'
        ]);

        $categoria = Categoria::create($data);

        return response()->json($categoria, 201);
    }
}
