<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SolicitudCartaPresentacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'estudiante_id',
        'estadia_id',
        'dirigida_a',
        'cargo_destinatario',
        'proposito',
        'observaciones',
        'estado',
        'fecha_solicitud',
        'fecha_procesada',
        'procesada_por',
        'comentarios_coordinador',
        'archivo_carta',
        // Campos del flujo de aprobación profesor
        'fecha_revision_profesor',
        'fecha_aprobacion_profesor',
        'revisada_por_profesor',
        'comentarios_profesor',
        // Campos del flujo de aprobación director
        'fecha_revision_director',
        'fecha_aprobacion_director',
        'aprobada_por_director',
        'revisada_por_director',
        'comentarios_director',
        // Campos para firma digital y archivos
        'archivo_firmado',
        'firma_director',
        'progreso',
        'empresa_nombre',
        'fecha_inicio',
        'fecha_fin'
    ];

    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_procesada' => 'datetime',
        'fecha_revision_profesor' => 'datetime',
        'fecha_aprobacion_profesor' => 'datetime',
        'fecha_revision_director' => 'datetime',
        'fecha_aprobacion_director' => 'datetime'
    ];

    /**
     * Relación con el estudiante
     */
    public function estudiante(): BelongsTo
    {
        return $this->belongsTo(Estudiante::class);
    }

    /**
     * Relación con la estadía
     */
    public function estadia(): BelongsTo
    {
        return $this->belongsTo(Estadia::class);
    }

    /**
     * Relación con el usuario que procesó la solicitud
     */
    public function procesadaPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'procesada_por');
    }

    /**
     * Relación con el profesor que revisó la solicitud
     */
    public function revisadaPorProfesor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revisada_por_profesor');
    }

    /**
     * Relación con el director que aprobó la solicitud
     */
    public function aprobadaPorDirector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'aprobada_por_director');
    }

    /**
     * Relación con el director que revisó la solicitud
     */
    public function revisadaPorDirector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revisada_por_director');
    }

    /**
     * Scope para solicitudes pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para solicitudes aprobadas por profesor
     */
    public function scopeAprobadasProfesor($query)
    {
        return $query->where('estado', 'aprobada_profesor');
    }

    /**
     * Scope para solicitudes aprobadas por director
     */
    public function scopeAprobadasDirector($query)
    {
        return $query->where('estado', 'aprobada_director');
    }

    /**
     * Scope para solicitudes pendientes de revisión del profesor
     */
    public function scopePendientesProfesor($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para solicitudes pendientes de revisión del director
     */
    public function scopePendientesDirector($query)
    {
        return $query->where('estado', 'aprobada_profesor');
    }

    /**
     * Scope para solicitudes en revisión
     */
    public function scopeEnRevision($query)
    {
        return $query->where('estado', 'pendiente');
    }

    /**
     * Scope para solicitudes generadas
     */
    public function scopeGeneradas($query)
    {
        return $query->where('estado', 'generada');
    }

    /**
     * Obtener el estado con formato legible
     */
    public function getEstadoFormateadoAttribute()
    {
        $estados = [
            'pendiente' => 'Pendiente de Revisión',
            'aprobada_profesor' => 'Aprobada por Profesor',
            'rechazada_profesor' => 'Rechazada por Profesor',
            'aprobada_director' => 'Aprobada por Director',
            'rechazada_director' => 'Rechazada por Director',
            'generada' => 'Carta Generada'
        ];

        return $estados[$this->estado] ?? ucfirst($this->estado);
    }

    /**
     * Obtener el progreso del trámite (0-100)
     */
    public function getProgresoAttribute()
    {
        $progresos = [
            'pendiente' => 20,
            'aprobada_profesor' => 50,
            'rechazada_profesor' => 0,
            'aprobada_director' => 80,
            'rechazada_director' => 0,
            'generada' => 100
        ];

        return $progresos[$this->estado] ?? 0;
    }

    /**
     * Obtener el color del estado para la UI
     */
    public function getColorEstadoAttribute()
    {
        $colores = [
            'pendiente' => 'warning',
            'aprobada_profesor' => 'info',
            'rechazada_profesor' => 'danger',
            'aprobada_director' => 'primary',
            'rechazada_director' => 'danger',
            'generada' => 'success'
        ];

        return $colores[$this->estado] ?? 'secondary';
    }
}
