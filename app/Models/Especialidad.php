<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    use HasFactory;

    protected $table = 'especialidades';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'carrera_id',
        'nombre',
        'codigo',
        'descripcion',
        'creditos_requeridos',
        'cuatrimestre_inicio',
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
     * Relación con el modelo Carrera
     */
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    /**
     * Relación con estadias (muchas estadias pueden tener la misma especialidad)
     */
    public function estadias()
    {
        return $this->hasMany(Estadia::class);
    }

    /**
     * Scope para especialidades activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }

    /**
     * Scope para especialidades por carrera
     */
    public function scopePorCarrera($query, $carreraId)
    {
        return $query->where('carrera_id', $carreraId);
    }

    /**
     * Scope para especialidades disponibles en un cuatrimestre específico
     */
    public function scopeDisponiblesEnCuatrimestre($query, $cuatrimestre)
    {
        return $query->where('cuatrimestre_inicio', '<=', $cuatrimestre);
    }

    /**
     * Obtener el número de estadias activas en esta especialidad
     */
    public function getEstadiasActivasAttribute()
    {
        return $this->estadias()->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])->count();
    }

    /**
     * Obtener el nombre completo con carrera
     */
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' - ' . $this->carrera->nombre;
    }
}