<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionTutor extends Model
{
    use HasFactory;

    protected $table = 'asignaciones_tutor';

    protected $fillable = [
        'tutor_id',
        'estudiante_id',
        'carrera_id',
        'director_id',
        'periodo',
        'status',
        'fecha_asignacion',
        'fecha_completada',
        'motivo_cambio'
    ];

    protected $casts = [
        'fecha_asignacion' => 'datetime',
        'fecha_completada' => 'datetime',
    ];

    /**
     * Relación con el tutor (profesor)
     */
    public function tutor()
    {
        return $this->belongsTo(Profesor::class, 'tutor_id');
    }

    /**
     * Relación con el estudiante
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    /**
     * Relación con la carrera
     */
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    /**
     * Relación con el director
     */
    public function director()
    {
        return $this->belongsTo(Profesor::class, 'director_id');
    }
}