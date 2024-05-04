<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Ingresar datos de gastronomía</h1>
    <form action="{{ route('gastronomia.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="imagen">Imagen:</label>
            <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*" required>
        </div>
        
        <div class="form-group">
            <label for="id_sitio">Sitio:</label>
            <select name="id_sitio" id="id_sitio" class="form-control" required>
                @foreach($sitios as $sitio)
                <option value="{{ $sitio->id }}">{{ $sitio->nombre }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</body>

</html>