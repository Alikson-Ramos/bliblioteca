<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        return response()->json(Categoria::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|unique:categorias,nome'
        ]);
        $categoria = Categoria::create($data);
        return response()->json($categoria, 201);
    }

    public function show($id)
    {
        $categoria = Categoria::findOrFail($id);
        return response()->json($categoria);
    }

    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);
        $data = $request->validate([
            'nome' => 'required|unique:categorias,nome,' . $categoria->id
        ]);
        $categoria->update($data);
        return response()->json($categoria);
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();
        return response()->json(['message' => 'Categoria excluída com sucesso.']);
    }
}
