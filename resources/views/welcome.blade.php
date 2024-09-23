<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    @include('partials.navbar')
    <div class="container mt-5">
        <div class="text-center mb-4">
            <a href="{{ route('listas.index') }}" class="btn btn-primary">Ver Listas de Tareas</a>
        </div>
        <h1 class="text-center">Lista de Tareas</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h2 class="mt-4">Tareas</h2>
        <ul class="list-group">
            @foreach ($tareas as $tarea)
                @if ($tarea->estado != 3)
                    <!-- Mostrar solo tareas no eliminadas -->
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <h5>{{ $tarea->titulo }}</h5>
                            <p>{{ $tarea->detalle }}</p>
                            <span
                                class="badge 
                                @if ($tarea->estado == 0) bg-warning 
                                @elseif($tarea->estado == 1) bg-success 
                                @elseif($tarea->estado == 2) bg-info @endif">
                                {{ $tarea->getEstadoText() }}
                            </span>
                        </div>
                        <div>
                            <!-- Botón para eliminar tarea -->
                            <form action="{{ route('tareas.destroy', $tarea->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                            <!-- Botón para ver historial -->
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                data-bs-target="#historialModal{{ $tarea->id }}">
                                Historial
                            </button>
                        </div>
                    </li>

                    <!-- Modal para mostrar historial de la tarea -->
                    <div class="modal fade" id="historialModal{{ $tarea->id }}" tabindex="-1"
                        aria-labelledby="historialModalLabel{{ $tarea->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="historialModalLabel{{ $tarea->id }}">Historial de
                                        Tarea: {{ $tarea->titulo }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Fecha de Creación:</strong>
                                        {{ $tarea->created_at ? $tarea->created_at->format('d/m/Y') : 'Fecha no disponible' }}
                                    </p>
                                    <p><strong>Título:</strong> {{ $tarea->titulo }}</p>
                                    <p><strong>Detalle:</strong> {{ $tarea->detalle }}</p>
                                    <p><strong>Estado Actual:</strong> {{ $tarea->getEstadoText() }}</p>
                                    <p><strong>Lista Asociada:</strong>
                                        @if ($tarea->listas->isNotEmpty())
                                            @foreach ($tarea->listas as $lista)
                                                {{ $lista->nombrelista }}
                                                <!-- Asumiendo que el campo de la lista es 'nombre' -->
                                            @endforeach
                                        @else
                                            No tiene lista asociada
                                        @endif

                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </ul>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
