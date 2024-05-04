<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="imagen">
        <button type="submit">Subir imagen</button>
    </form>


    <form action="{{ route('categoria.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="text" name="tipo" placeholder="Tipo de turismo"> <!-- Campo para el tipo de imagen -->
        <input type="file" name="imagen">
        <button type="submit">Subir imagen</button>
    </form>

    <form action="{{ route('sitio.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Campos existentes -->
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>
        <br>

        <label for="imagen">Imagen:</label>
        <input type="file" name="imagen" id="imagen" accept="image/*" required>
        <br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" rows="4" required></textarea>
        <br>

        <label for="ubicacion">Ubicación:</label>
        <input type="text" name="ubicacion" id="ubicacion" required>
        <br>

        <!-- Nuevos campos para latitud y longitud -->
        <label for="latitud">Latitud:</label>
        <input type="text" name="latitud" id="latitud" required>
        <br>

        <label for="longitud">Longitud:</label>
        <input type="text" name="longitud" id="longitud" required>
        <br>
        <!-- Fin de los nuevos campos -->

        <label for="id_categoria">Categoría:</label>
        <select name="id_categoria" required>
            <option value="" selected disabled>Selecciona una categoría</option>
            @foreach($lugartipo as $categoria)
            <option value="{{ $categoria->id }}">{{ $categoria->tipo }}</option>
            @endforeach
        </select>
        <br>

        <button type="submit">Guardar</button>
    </form>





</body>

</html>