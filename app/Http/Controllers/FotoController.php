<?php

namespace App\Http\Controllers;

use App\Models\Sitio;
use App\Models\Foto;


use Illuminate\Http\Request;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los lugares disponibles
        $lugares = Sitio::all();
        // Pasar los lugares a la vista del formulario
        return view('foto', compact('lugares'));
    }
    public function index2(Request $request)
    {
        // Obtener el ID del sitio seleccionado (si se proporciona)
        $sitioId = $request->query('id_sitio');

        // Filtrar las fotos por el ID del sitio si se proporciona, de lo contrario, mostrar todas las fotos
        $fotos = $sitioId ? Foto::where('id_sitio', $sitioId)->get(['id', 'imagen', 'id_sitio']) : Foto::all(['id', 'imagen', 'id_sitio']);

        $fotosFormatados = [];

        foreach ($fotos as $foto) {
            // Obtener los datos binarios de la imagen desde el modelo
            $imagenBlob = $foto->imagen;

            // Agregar los datos binarios de la imagen a la lista de fotos
            $fotosFormatados[] = [
                'id' => $foto->id,
                'imagen' => base64_encode($imagenBlob), // Codificar la imagen como base64
                'id_sitio' => $foto->id_sitio,
            ];
        }

        return response()->json($fotosFormatados);
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
        // Validar la petición y asegurarse de que se envió una imagen
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif', // Ajusta las reglas según tus necesidades
            'id_sitio' => 'required|exists:sitios,id' // Asegúrate de que el id_sitio exista en la tabla de sitios
        ]);

        // Obtener el archivo de imagen del request
        $imagen = $request->file('imagen');

        // Convertir la imagen a un BLOB
        $imagenBlob = file_get_contents($imagen->getRealPath());

        // Crear una nueva instancia de Foto
        $foto = new Foto();
        $foto->id_sitio = $request->id_sitio; // Corregir id_lugar a id_sitio
        $foto->imagen = $imagenBlob;
        $foto->save();

        // Retornar una respuesta o redireccionar a donde sea necesario
        return response()->json(['mensaje' => 'Imagen guardada correctamente']);
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
