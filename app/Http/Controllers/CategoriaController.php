<?php

namespace App\Http\Controllers;

use App\Models\Categoria;


use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listado = Categoria::all(['id', 'tipo', 'imagen']);
        $categorias = [];

        foreach ($listado as $categoria) {
            // Obtener los datos binarios de la imagen desde el modelo
            $imagenBlob = $categoria->imagen;

            // Agregar los datos binarios de la imagen a la lista de categorías
            $categorias[] = [
                'id' => $categoria->id,
                'tipo' => $categoria->tipo,
                'imagen' => base64_encode($imagenBlob), // Codificar la imagen como base64
            ];
        }

        return response()->json($categorias);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valida los datos de entrada
        $request->validate([
            'tipo' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ajusta los tipos de imagen y el tamaño máximo según tus necesidades
        ]);

        // Obtén la imagen del formulario
        $imagen = $request->file('imagen');

        // Convierte la imagen a un formato binario (blob)
        $imagenBlob = file_get_contents($imagen->getRealPath());

        // Crea una nueva instancia del modelo Imagen
        $imagenModel = new Categoria();
        $imagenModel->tipo = $request->tipo;
        $imagenModel->imagen = $imagenBlob;

        // Guarda la imagen en la base de datos
        $imagenModel->save();

        // Redirecciona o responde según tus necesidades
        return redirect()->back()->with('success', 'Imagen guardada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
