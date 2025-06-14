<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;

class LivroController extends Controller
{
    public function index()
    {
        return response()->json(Livro::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|unique:livros,titulo',
            'ano_publicacao' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
            'status' => 'in:disponível,emprestado'
        ]);

        $livro = Livro::create($data);

        return response()->json($livro, 201);
    }

    public function show($id)
    {
        $livro = Livro::findOrFail($id);
        return response()->json($livro);
    }

    public function update(Request $request, $id)
    {
        $livro = Livro::findOrFail($id);
        $data = $request->validate([
            'titulo' => 'required|unique:livros,titulo,' . $livro->id,
            'ano_publicacao' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
            'status' => 'in:disponível,emprestado'
        ]);
        $livro->update($data);
        return response()->json($livro);
    }

    public function destroy($id)
    {
        $livro = Livro::findOrFail($id);
        $livro->delete();

        return response()->json(['message' => 'Livro excluído com sucesso.']);
    }
}
