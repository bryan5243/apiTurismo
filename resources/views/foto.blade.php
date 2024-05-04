<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="{{ route('foto.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Campo select para seleccionar el lugar -->
        <div class="form-group">
            <label for="id_sitio">Seleccionar lugar:</label>
            <select class="form-control" id="id_sitio" name="id_sitio">
                <option value="" selected disabled>Selecciona un lugar</option>

                @foreach ($lugares as $lugar)
                <option value="{{ $lugar->id }}">{{ $lugar->nombre }}</option>
                @endforeach
            </select>
            @error('id_lugar')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Campo para seleccionar la imagen -->
        <div class="form-group">
            <label for="imagen">Seleccionar imagen:</label>
            <input type="file" class="form-control" id="imagen" name="imagen">
            @error('imagen')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botón para enviar el formulario -->
        <button type="submit" class="btn btn-primary">Guardar Imagen</button>
    </form>
</body>

</html>