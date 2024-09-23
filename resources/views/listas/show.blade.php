<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Lista</title>
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

        h1,
        h2 {
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

        .modal-header {
            background-color: #007bff;
            color: white;
        }

        .modal-footer {
            justify-content: flex-start;
        }
    </style>
</head>

<body>
    @include('partials.navbar')

    <div class="container mt-5">
        <h1>{{ $lista->nombrelista }}</h1>
        <p>{{ $lista->descripcionlista }}</p>

        <!-- Mostrar el estado de la lista -->
        <h2>
            <span
                class="badge 
                @if ($lista->estado == 0) bg-warning 
                @elseif ($lista->estado == 1) bg-info 
                @elseif ($lista->estado == 2) bg-success 
                @elseif ($lista->estado == 3) bg-secondary @endif">
                @if ($lista->estado == 0)
                    Por hacer
                @elseif ($lista->estado == 1)
                    En progreso
                @elseif ($lista->estado == 2)
                    Completada
                @elseif ($lista->estado == 3)
                    Eliminada
                @endif
            </span>
        </h2>

        <h2>Elegir una Opción</h2>
        <div class="d-flex mb-4">
            <!-- Botón para cambiar el estado de la lista -->
            <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#estadoModal">
                Cambiar Estado
            </button>
            <!-- Botón para añadir tarea -->
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addTareaModal">
                Añadir Tarea
            </button>
        </div>

        <!-- Modal para cambiar estado -->
        <div class="modal fade" id="estadoModal" tabindex="-1" aria-labelledby="estadoModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="estadoModalLabel">Cambiar Estado de la Lista</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('listas.update', $lista->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="estado" class="form-label">Selecciona el nuevo estado:</label>
                                <select name="estado" id="estado" class="form-select">
                                    <option value="0">Por hacer</option>
                                    <option value="1">En progreso</option>
                                    <option value="2">Completada</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addTareaModal" tabindex="-1" aria-labelledby="addTareaModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTareaModalLabel">Añadir Tarea</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('tareas.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="lista_id" value="{{ $lista->id }}">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título de la tarea:</label>
                                <input type="text" name="titulo" id="titulo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="detalle" class="form-label">Detalle de la tarea:</label>
                                <textarea name="detalle" id="detalle" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Añadir Tarea</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <h3>Tareas Asociadas</h3>
        <ul class="list-group mt-4" id="tareasList">
            @forelse ($lista->tareas->take(5) as $tarea)
                <li class="list-group-item d-flex justify-content-between align-items-center"
                    data-tarea-id="{{ $tarea->id }}">
                    <span class="tarea-titulo">{{ $tarea->titulo }} <span
                            class="badge bg-secondary">{{ $tarea->getEstadoText() }}</span>
                        <form action="{{ route('tareas.destroy', $tarea->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </span>
                    <span>
                        <form action="{{ route('tareas.update', $tarea->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" name="estado" value="0" class="btn btn-warning btn-sm">Por
                                Realizar</button>
                            <button type="submit" name="estado" value="1" class="btn btn-success btn-sm">En
                                Progreso</button>
                            <button type="submit" name="estado" value="2"
                                class="btn btn-info btn-sm">Hecha</button>
                        </form>
                    </span>
                </li>
            @empty
                <li class="list-group-item">No hay tareas asociadas a esta lista.</li>
            @endforelse
        </ul>

        <a href="{{ route('listas.index') }}" class="btn btn-primary mt-3">Visualizar todas las listas</a>
        <button type="button" class="btn btn-info mt-3" data-bs-toggle="modal" data-bs-target="#allTareasModal">
            Ver todas las tareas
        </button>

        <div class="modal fade" id="allTareasModal" tabindex="-1" aria-labelledby="allTareasModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="allTareasModalLabel">Todas las Tareas de la Lista</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul class="list-group">
                            @forelse ($lista->tareas as $tarea)
                                <li class="list-group-item d-flex justify-content-between align-items-center"
                                    data-tarea-id="{{ $tarea->id }}">
                                    <span class="tarea-titulo">{{ $tarea->titulo }} <span
                                            class="badge bg-secondary">{{ $tarea->getEstadoText() }}</span>
                                        <form action="{{ route('tareas.destroy', $tarea->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </span>
                                    <span>
                                        <form action="{{ route('tareas.update', $tarea->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="estado" value="0"
                                                class="btn btn-warning btn-sm">Por Realizar</button>
                                            <button type="submit" name="estado" value="1"
                                                class="btn btn-success btn-sm">En Progreso</button>
                                            <button type="submit" name="estado" value="2"
                                                class="btn btn-info btn-sm">Hecha</button>
                                        </form>
                                    </span>
                                </li>
                            @empty
                                <li class="list-group-item">No hay tareas asociadas a esta lista.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
