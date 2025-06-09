<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Http\Request;

class AutorController extends Controller
{
    public function index()
    {
        return response()->json(Autor::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string',
            'biografia' => 'nullable|string'
        ]);

        $autor = Autor::create($data);

        return response()->json($autor, 201);
    }

    public function show($id)
    {
        $autor = Autor::findOrFail($id);
        return response()->json($autor);
    }

    public function update(Request $request, $id)
    {
        $autor = Autor::findOrFail($id);

        $data = $request->validate([
            'nome' => 'required|string',
            'biografia' => 'nullable|string'
        ]);

        $autor->update($data);

        return response()->json($autor);
    }

    public function destroy($id)
    {
        $autor = Autor::findOrFail($id);

        // Lembrar de validar se existe livro associado.
        $autor->delete();

        return response()->json(['message' => 'Autor excluído com sucesso.']);
    }
}
