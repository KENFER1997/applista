<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    use HasFactory;

    protected $table = 'listas';

    protected $fillable = [
        'nombrelista',
        'descripcionlista',
        'estado',
    ];

    public function tareas()
    {
        return $this->belongsToMany(Tarea::class, 'lista_tarea', 'lista_id', 'tarea_id');
    }

    public function isCompletada()
    {
        return $this->tareas()->where('tarea_lista.estado', '!=', 1)->count() === 0; 
    }
}
