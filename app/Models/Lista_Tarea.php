<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ListaTarea extends Pivot
{
    protected $table = 'lista_tarea'; // Nombre de la tabla pivot


    public function tareas()
    {
        return $this->belongsTo(tarea::class);
    }

    public function lista()
    {
        return $this->belongsTo(Lista::class);
    }
}
