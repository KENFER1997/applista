<?php

namespace App\Http\Controllers;

use App\Models\Lista;
use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    public function index()
    {
        
        $tareas = Tarea::all();
        $listas = Lista::all(); 
        //dd($tareas);
        return view('welcome', compact('tareas', 'listas')); 
    }

    public function create(Request $request)
    {
        
        $listaId = $request->input('lista_id');
        return view('welcome', compact('listaId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'detalle' => 'nullable|string',
            'lista_id' => 'required|exists:listas,id', 
        ]);

        $tarea = new Tarea();
        $tarea->titulo = $request->titulo;
        $tarea->detalle = $request->detalle;
        $tarea->estado = 0;
        $tarea->lista_id = $request->lista_id;
        $tarea->save();

        $tarea->listas()->attach($request->lista_id);

        return redirect()->route('listas.show', ['lista' => $request->lista_id])
            ->with('success', 'Tarea agregada exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $tarea = Tarea::findOrFail($id);

        $estado = $request->input('estado');
        if ($estado !== null) {
            $tarea->estado = $estado; 
        }

        //$tarea->fechaUpdate = getdate(); // Actualiza la fecha de modificación
        $tarea->save(); 

        return redirect()->route('listas.show', $tarea->lista_id)->with('success', 'Tarea actualizada correctamente.');
    }


    public function destroy($id)
    {
        $tarea = Tarea::findOrFail($id);
        $lista_id = $tarea->lista_id; 
        $tarea->delete();
        $tarea->fechaDelete = now();
        $tarea->save();

        return redirect()->route('listas.show', $lista_id)->with('success', 'Tarea eliminada.');
    }
}
