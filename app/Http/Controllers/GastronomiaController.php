<?php

namespace App\Http\Controllers;

use App\Models\Sitio;
use App\Models\Gastronomia;


use Illuminate\Http\Request;

class GastronomiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener el ID del sitio seleccionado (si se proporciona)
        $sitioId = $request->query('id_sitio');

        // Filtrar las gastronomías por el ID del sitio si se proporciona, de lo contrario, mostrar todas las gastronomías
        $gastronomias = $sitioId ? Gastronomia::where('id_sitio', $sitioId)->get(['id', 'nombre', 'imagen', 'estado', 'id_sitio']) : Gastronomia::all(['id', 'nombre', 'imagen', 'estado', 'id_sitio']);

        $gastronomiasFormatadas = [];

        foreach ($gastronomias as $gastronomia) {
            // Obtener los datos binarios de la imagen desde el modelo
            $imagenBlob = $gastronomia->imagen;

            // Agregar los datos binarios de la imagen a la lista de gastronomías
            $gastronomiasFormatadas[] = [
                'id' => $gastronomia->id,
                'nombre' => $gastronomia->nombre,
                'imagen' => base64_encode($imagenBlob), // Codificar la imagen como base64
                'estado' => $gastronomia->estado,
                'id_sitio' => $gastronomia->id_sitio,
            ];
        }

        return response()->json($gastronomiasFormatadas);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sitios = Sitio::all(); // Asumiendo que Sitio es el modelo para la tabla "sitios"
        return view('gastronomia', compact('sitios'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valida los datos de entrada
        $request->validate([
            'nombre' => 'required|string',
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif',
            'id_sitio' => 'required|exists:sitios,id', // Asegúrate de que exista el sitio en la tabla sitios
        ]);

        // Obtén la imagen del formulario y conviértela a un formato blob
        $imagen = $request->file('imagen');
        $imagenBlob = file_get_contents($imagen->getRealPath());

        // Crea una nueva instancia del modelo Gastronomia
        $gastronomia = new Gastronomia();
        $gastronomia->nombre = $request->nombre;
        $gastronomia->imagen = $imagenBlob;
        $gastronomia->id_sitio = $request->id_sitio;
        $gastronomia->save();

        // Redirecciona o responde según tus necesidades
        return redirect()->back()->with('success', 'Datos guardados correctamente.');
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
