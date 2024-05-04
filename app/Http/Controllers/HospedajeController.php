<?php

namespace App\Http\Controllers;

use App\Models\Sitio;
use App\Models\Hospedaje;


use Illuminate\Http\Request;

class HospedajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener el ID del sitio seleccionado (si se proporciona)
        $sitioId = $request->query('id_sitio');

        // Filtrar los hospedajes por el ID del sitio si se proporciona, de lo contrario, mostrar todos los hospedajes
        $hospedajes = $sitioId ? Hospedaje::where('id_sitio', $sitioId)->get(['id', 'nombre', 'imagen', 'estado', 'id_sitio']) : Hospedaje::all(['id', 'nombre', 'imagen', 'estado', 'id_sitio']);

        $hospedajesFormatados = [];

        foreach ($hospedajes as $hospedaje) {
            // Obtener los datos binarios de la imagen desde el modelo
            $imagenBlob = $hospedaje->imagen;

            // Agregar los datos binarios de la imagen a la lista de hospedajes
            $hospedajesFormatados[] = [
                'id' => $hospedaje->id,
                'nombre' => $hospedaje->nombre,
                'imagen' => base64_encode($imagenBlob), // Codificar la imagen como base64
                'estado' => $hospedaje->estado,
                'id_sitio' => $hospedaje->id_sitio,
            ];
        }

        return response()->json($hospedajesFormatados);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sitios = Sitio::all(); // Asumiendo que Sitio es el modelo para la tabla "sitios"
        return view('hospedaje', compact('sitios'));
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

        // Crea una nueva instancia del modelo Hospedaje
        $hospedaje = new Hospedaje();
        $hospedaje->nombre = $request->nombre;
        $hospedaje->imagen = $imagenBlob;
        $hospedaje->id_sitio = $request->id_sitio;
        $hospedaje->save();

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
