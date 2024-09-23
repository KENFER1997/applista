<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            color: #343a40;
        }

        .list-group-item {
            transition: background-color 0.3s;
        }

        .list-group-item:hover {
            background-color: #e9ecef;
        }

        .badge {
            font-size: 0.85em;
        }
    </style>
</head>

<body>
    @include('partials.navbar')

    <div class="container mt-5">
        <!-- Cabecera con el botón para crear lista -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Vista de Listas</h1>
            <!-- Botón para crear una nueva lista -->
            <a href="{{ route('listas.create') }}" class="btn btn-success">Crear Nueva Lista</a>
        </div>

        <!-- Lista de listas -->
        <ul class="list-group">
            @foreach ($listas as $lista)
                @if ($lista->estado != 3)
                    <!-- Solo mostrar las listas que no están eliminadas -->
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <span>{{ $lista->nombrelista }}</span>
                            <!-- Muestra el estado de la lista -->
                            <span
                                class="badge 
                                @if ($lista->estado == 0) bg-warning 
                                @elseif($lista->estado == 1) bg-info 
                                @elseif($lista->estado == 2) bg-success @endif">
                                @if ($lista->estado == 0)
                                    Por hacer
                                @elseif ($lista->estado == 1)
                                    En progreso
                                @elseif ($lista->estado == 2)
                                    Completada
                                @endif
                            </span>
                        </div>

                        <!-- Botones para agregar tarea, ver lista de tareas y eliminar lista -->
                        <div>
                            <!-- Botón para ver lista de tareas -->
                            <a href="{{ route('listas.show', $lista->id) }}" class="btn btn-info btn-sm">Ver detalle</a>

                            <!-- Botón para eliminar lista -->
                            <form action="{{ route('listas.destroy', $lista->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </div>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
