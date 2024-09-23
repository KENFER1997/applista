<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nueva Lista</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @include('partials.navbar')
    <div class="container mt-5">
        <h2>Crear nueva lista</h2>
        <form action="{{ route('listas.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="nombrelista">Nombre de la lista:</label>
                <input type="text" name="nombrelista" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="descripcionlista">Descripción:</label>
                <textarea name="descripcionlista" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Crear Lista</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
