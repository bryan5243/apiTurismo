<?php

namespace App\Http\Controllers;



use App\Models\Slider;


use Illuminate\Http\Request;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $sliders = Slider::all();
        $imagenes = [];

        foreach ($sliders as $slider) {
            // Obtener los datos binarios de la imagen desde el modelo
            $imagenBlob = $slider->imagen;

            // Agregar los datos binarios de la imagen a la lista de imágenes
            $imagenes[] = [
                'id' => $slider->id,
                'imagen' => base64_encode($imagenBlob), // Codificar la imagen como base64
            ];
        }

        return response()->json($imagenes);
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
        // Verificar si se ha enviado una imagen
        if ($request->hasFile('imagen')) {
            // Obtener información sobre la imagen
            $imagen = $request->file('imagen');
            echo 'Nombre del archivo: ' . $imagen->getClientOriginalName();
            echo 'Tamaño del archivo: ' . $imagen->getSize();
        } else {
            echo 'No se ha enviado ninguna imagen.';
        }

        // Validar la solicitud para asegurarse de que se esté enviando una imagen
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096', // Ajusta los tipos de archivo y el tamaño máximo según tus necesidades
        ]);

        // Obtener la imagen de la solicitud
        $imagen = $request->file('imagen');

        // Si necesitas redimensionar la imagen, llama a la función redimensionarImagen
        $imagenRedimensionada = $this->redimensionarImagen($imagen, 1500, 590);

        // Convierte la imagen redimensionada a un formato binario (blob)
        $imagenBlob = file_get_contents($imagenRedimensionada->getRealPath());
        // Convertir la imagen a un objeto Blob
        $imagenBlob = file_get_contents($imagen->getRealPath());

        // Guardar el Blob en la base de datos
        $slider = new Slider();
        $slider->imagen = $imagenBlob;
        $slider->save();

        return redirect()->back()->with('success', 'Imagen guardada correctamente.');
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
