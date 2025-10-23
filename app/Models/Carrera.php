<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $table = 'carreras';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'codigo',
        'descripcion',
        'duracion_cuatrimestres',
        'creditos_totales',
        'modalidad',
        'director_id',
        'activa',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activa' => 'boolean',
    ];

    /**
     * Relación con estudiantes
     */
    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
    }

    /**
     * Relación con especialidades
     */
    public function especialidades()
    {
        return $this->hasMany(Especialidad::class);
    }

    /**
     * Relación con el director (profesor)
     */
    public function director()
    {
        return $this->belongsTo(Profesor::class, 'director_id');
    }

    /**
     * Relación con estadias a través de estudiantes
     */
    public function estadias()
    {
        return $this->hasManyThrough(Estadia::class, Estudiante::class);
    }

    /**
     * Scope para carreras activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }

    /**
     * Scope para carreras por modalidad
     */
    public function scopePorModalidad($query, $modalidad)
    {
        return $query->where('modalidad', $modalidad);
    }

    /**
     * Obtener el número total de estudiantes activos
     */
    public function getTotalEstudiantesActivosAttribute()
    {
        return $this->estudiantes()->activos()->count();
    }

    /**
     * Obtener el número de estudiantes por cuatrimestre
     */
    public function getEstudiantesPorCuatrimestreAttribute()
    {
        return $this->estudiantes()
                   ->activos()
                   ->selectRaw('cuatrimestre, COUNT(*) as total')
                   ->groupBy('cuatrimestre')
                   ->pluck('total', 'cuatrimestre')
                   ->toArray();
    }

    /**
     * Obtener estadias activas de la carrera
     */
    public function getEstadiasActivasAttribute()
    {
        return $this->estadias()->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])->count();
    }
}