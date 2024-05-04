<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Sitio;
use Intervention\Image\Facades\Image;


use Illuminate\Http\Request;

class SitioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los lugares disponibles
        $lugartipo = Categoria::all();
        // Pasar los lugares a la vista del formulario
        return view('welcome', compact('lugartipo'));
    }


    public function index2(Request $request)
    { {
            $categorias = Categoria::all();
            // Obtén el ID de la categoría seleccionada (si se proporciona)
            $categoriaId = $request->query('categoria_id');
            if ($categoriaId) {
                // Filtra los lugares por el ID de la categoría
                $listado = Sitio::where('id_categoria', $categoriaId)->get(['id', 'nombre', 'imagen', 'descripcion', 'ubicacion', 'latitude', 'longitude']);
            } else {
                // Si no se proporciona un ID de categoría, muestra todos los lugares
                $listado = Sitio::all(['id', 'nombre', 'imagen', 'descripcion', 'ubicacion', 'latitude', 'longitude']);
            }

            $lugares = [];

            foreach ($listado as $lugar) {
                // Obtener los datos binarios de la imagen desde el modelo
                $imagenBlob = $lugar->imagen;

                // Agregar los datos binarios de la imagen a la lista de categorías
                $lugares[] = [
                    'id' => $lugar->id,
                    'nombre' => $lugar->nombre,
                    'imagen' => base64_encode($imagenBlob),
                    'descripcion' => $lugar->descripcion,
                    'ubicacion' => $lugar->ubicacion,
                    'latitude' => $lugar->latitude,
                    'longitude' => $lugar->longitude,
                ];
            }

            return response()->json($lugares);
        }
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
     */ public function store(Request $request)
{
    // Valida los datos de entrada
    $request->validate([
        'nombre' => 'required|string',
        'imagen' => 'required|image|mimes:jpeg,png,jpg,gif',
        'descripcion' => 'required|string',
        'ubicacion' => 'required|string',
        'latitud' => 'required|numeric', // Validar la latitud como un número
        'longitud' => 'required|numeric', // Validar la longitud como un número
        'id_categoria' => 'required|exists:categorias,id', // Asegúrate de que exista la categoría en la tabla categorias
    ]);

    // Obtén la imagen del formulario
    $imagen = $request->file('imagen');

    // Si necesitas redimensionar la imagen, llama a la función redimensionarImagen
    $imagenRedimensionada = $this->redimensionarImagen($imagen, 500, 600);

    // Convierte la imagen redimensionada a un formato binario (blob)
    $imagenBlob = file_get_contents($imagenRedimensionada->getRealPath());

    // Crea una nueva instancia del modelo Sitio
    $sitio = new Sitio();
    $sitio->nombre = $request->nombre;
    $sitio->imagen = $imagenBlob;
    $sitio->descripcion = $request->descripcion;
    $sitio->ubicacion = $request->ubicacion;
    $sitio->latitude = $request->latitud; // Guardar la latitud
    $sitio->longitude = $request->longitud; // Guardar la longitud
    $sitio->id_categoria = $request->id_categoria;
    $sitio->save();

    // Redirecciona o responde según tus necesidades
    return redirect()->back()->with('success', 'Datos guardados correctamente.');
}

private function redimensionarImagen($imagen, $width, $height)
{
    // Crea una nueva imagen a partir de la original
    $imagenOriginal = imagecreatefromstring(file_get_contents($imagen->getRealPath()));
    $nuevaImagen = imagecreatetruecolor($width, $height);

    // Redimensiona la imagen a la nueva resolución
    imagecopyresampled($nuevaImagen, $imagenOriginal, 0, 0, 0, 0, $width, $height, imagesx($imagenOriginal), imagesy($imagenOriginal));

    // Guarda la imagen redimensionada en un archivo temporal con compresión ajustada
    $rutaTemporal = tempnam(sys_get_temp_dir(), 'img');
    imagejpeg($nuevaImagen, $rutaTemporal, 100); // Puedes ajustar el nivel de compresión aquí (90 es un valor de ejemplo)

    // Retorna la ruta temporal de la imagen redimensionada
    return new \Illuminate\Http\UploadedFile($rutaTemporal, $imagen->getClientOriginalName());
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
