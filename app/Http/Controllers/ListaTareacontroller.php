<?php

namespace App\Http\Controllers;

use App\Models\Lista;
use Illuminate\Http\Request;

class ListaTareaController extends Controller
{
   
    public function index()
    {
        $listas = Lista::with('tareas')->get(); 
        return view('listas.index', compact('listas'));
    }

    public function create()
    {
        return view('listas.create');
    }

    
    public function show($id)
    {
        $lista = Lista::with('tareas')->findOrFail($id); 
        $listas = Lista::all();
        return view('listas.show', compact('lista','listas'));
    }


    
    public function store(Request $request)
    {
        $request->validate([
            'nombrelista' => 'required|max:255',
            'descripcionlista' => 'nullable',
        ]);

        Lista::create([
            'nombrelista' => $request->nombrelista,
            'descripcionlista' => $request->descripcionlista,
        ]);

        return redirect()->route('listas.index'); 
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'estado' => 'required|in:0,1,2,3',
        ]);

        $tarea = Lista::findOrFail($id);
        $tarea->estado = $request->estado;
        $tarea->save();

        return redirect()->route('listas.index');
    }

    public function destroy(Request $request, $id)
    {
        $tarea = Lista::findOrFail($id);
        $tarea->estado = 3;
        $tarea->fechaDelete = now();
        $tarea->save();

        return redirect()->route('listas.index');
    }
}
