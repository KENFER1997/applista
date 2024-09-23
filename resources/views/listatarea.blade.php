@include('partials.navbar')
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $lista->nombrelista }}</h1>
        <p>{{ $lista->descripcionlista }}</p>

        <h2>Tareas</h2>
        <ul class="list-group">
            @foreach ($lista->tareas as $tarea)
                <li class="list-group-item">{{ $tarea->titulo }} - {{ $tarea->getEstadoText() }}</li>
            @endforeach
        </ul>

        <form action="{{ route('tareas.store') }}" method="POST" class="mt-3">
            @csrf
            <input type="hidden" name="lista_id" value="{{ $lista->id }}">
            <input type="text" name="titulo" placeholder="Título de la tarea" class="form-control" required>
            <textarea name="detalle" placeholder="Detalles (opcional)" class="form-control"></textarea>
            <button type="submit" class="btn btn-primary mt-2">Agregar Tarea</button>
        </form>
    </div>
@endsection
