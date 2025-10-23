<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'estudiantes';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'carrera_id',
        'especialidad_id',
        'matricula',
        'cuatrimestre',
        'telefono',
        'fecha_nacimiento',
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
        'fecha_nacimiento' => 'date',
    ];

    /**
     * Relación con el modelo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con el modelo Carrera
     */
    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    /**
     * Relación con el modelo Especialidad
     */
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    /**
     * Relación con el modelo Estadia
     */
    public function estadias()
    {
        return $this->hasMany(Estadia::class);
    }

    /**
     * Relación con el modelo Estadia (estadia actual)
     */
    public function estadiaActual()
    {
        return $this->hasOne(Estadia::class)->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca']);
    }

    /**
     * Relación con el modelo Estadia (alias para estadiaActual)
     */
    public function estadia()
    {
        return $this->hasOne(Estadia::class)->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca']);
    }

    /**
     * Relación con documentos a través de estadias
     */
    public function documentos()
    {
        return $this->hasManyThrough(
            Documento::class,
            Estadia::class,
            'estudiante_id', // Foreign key on estadias table
            'estadia_id',    // Foreign key on documentos table
            'id',            // Local key on estudiantes table
            'id'             // Local key on estadias table
        );
    }

    /**
     * Relación directa con citas
     */
    public function citas()
    {
        return $this->hasMany(Cita::class, 'estudiante_id');
    }

    /**
     * Relación con asignaciones de tutor
     */
    public function asignacionesTutor()
    {
        return $this->hasMany(AsignacionTutor::class, 'estudiante_id');
    }

    /**
     * Relación con la asignación de tutor activa
     */
    public function asignacionTutorActiva()
    {
        return $this->hasOne(AsignacionTutor::class, 'estudiante_id')
                    ->where('status', 'activa')
                    ->with('tutor.user');
    }

    /**
     * Obtener el tutor asignado actual
     */
    public function getTutorAsignadoAttribute()
    {
        $asignacion = $this->asignacionTutorActiva;
        return $asignacion ? $asignacion->tutor : null;
    }

    /**
     * Obtener el nombre completo del estudiante
     */
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido_paterno . ' ' . $this->apellido_materno;
    }

    /**
     * Scope para estudiantes activos
     * Nota: La tabla estudiantes no tiene campo 'activo', todos los estudiantes se consideran activos
     */
    public function scopeActivos($query)
    {
        return $query; // Retorna todos los estudiantes ya que no hay campo de estado
    }

    /**
     * Scope para estudiantes por carrera
     */
    public function scopePorCarrera($query, $carreraId)
    {
        return $query->where('carrera_id', $carreraId);
    }

    /**
     * Scope para estudiantes por cuatrimestre
     */
    public function scopePorCuatrimestre($query, $cuatrimestre)
    {
        return $query->where('cuatrimestre', $cuatrimestre);
    }
}