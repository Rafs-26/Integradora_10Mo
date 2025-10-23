<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;

    protected $table = 'profesores';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'numero_empleado',
        'departamento',
        'titulo_academico',
        'especialidades_docencia',
        'activo_como_tutor',
        'carrera_dirigida_id',
        'telefono',
        'direccion',
        'ciudad',
        'estado',
        'codigo_postal',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'activo_como_tutor' => 'boolean',
    ];

    /**
     * Relación con el modelo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con estudiantes supervisados (a través de estadias)
     */
    public function estudiantesSupervisados()
    {
        return $this->hasManyThrough(
            Estudiante::class,
            Estadia::class,
            'tutor_id', // Foreign key en estadias
            'id', // Foreign key en estudiantes
            'id', // Local key en profesores
            'estudiante_id' // Local key en estadias
        );
    }

    /**
     * Relación con estadias como supervisor
     */
    public function estadiasSupervisadas()
    {
        return $this->hasMany(Estadia::class, 'tutor_id');
    }

    /**
     * Relación con estadias como asesor académico
     */
    public function estadiasAsesoradas()
    {
        return $this->hasMany(Estadia::class, 'asesor_academico_id');
    }

    /**
     * Relación con todas las estadias (supervisor o asesor)
     */
    public function todasLasEstadias()
    {
        return Estadia::where('tutor_id', $this->id)
                     ->orWhere('asesor_academico_id', $this->id);
    }

    /**
     * Relación con citas como tutor
     */
    public function citas()
    {
        return $this->hasMany(Cita::class, 'tutor_id');
    }

    /**
     * Relación con documentos revisados
     */
    public function documentosRevisados()
    {
        return $this->hasMany(Documento::class, 'revisado_por');
    }

    /**
     * Obtener el nombre completo del profesor
     */
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno;
    }

    /**
     * Obtener el nombre con grado académico
     */
    public function getNombreConGradoAttribute()
    {
        $grado = $this->grado_academico ? $this->grado_academico . ' ' : '';
        return $grado . $this->nombre_completo;
    }

    /**
     * Scope para profesores activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo_como_tutor', true);
    }

    /**
     * Scope para profesores por departamento
     */
    public function scopePorDepartamento($query, $departamento)
    {
        return $query->where('departamento', $departamento);
    }

    /**
     * Scope para profesores supervisores
     */
    public function scopeSupervisores($query)
    {
        return $query->whereHas('estadiasSupervisadas');
    }

    /**
     * Scope para profesores asesores
     */
    public function scopeAsesores($query)
    {
        return $query->whereHas('estadiasAsesoradas');
    }
}