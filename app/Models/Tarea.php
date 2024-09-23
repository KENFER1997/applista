<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    use HasFactory;

    protected $table = 'tarea';

    protected $fillable = [
        'titulo',
        'detalle',
        'fechaCreacion',
        'fechaUpdate',
        'fechaDelete',
        'estado',
    ];

    protected $dates = [
        'fechaCreacion',
        'fechaUpdate',
        'fechaDelete'
    ];

    public $timestamps = true;

    public function listas()
    {
        return $this->belongsToMany(Lista::class, 'lista_tarea', 'tarea_id', 'lista_id');
    }

    public function getEstadoText()
    {
        switch ($this->estado) {
            case 0:
                return 'Por realizar';
            case 1:
                return 'En progreso';
            case 2:
                return 'Hecha';
            case 3:
                return 'Eliminada';
            default:
                return 'Desconocido';
        }
    }
}
