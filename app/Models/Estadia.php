<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estadia extends Model
{
    use HasFactory;

    protected $table = 'estadias';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'estudiante_id',
        'tutor_id',
        'empresa_id',
        'periodo',
        'fecha_solicitud',
        'fecha_inicio',
        'fecha_fin',
        'status',
        'proyecto',
        'area_empresa',
        'modalidad',
        'horas_semanales',
        'observaciones',
        'observaciones_tutor',
        'observaciones_biblioteca',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_solicitud' => 'datetime',
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
    ];

    /**
     * Relación con el modelo Estudiante
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class);
    }

    /**
     * Relación con el modelo Empresa
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /**
     * Relación con el modelo Especialidad
     */
    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class);
    }

    /**
     * Relación con el profesor supervisor
     */
    public function profesorSupervisor()
    {
        return $this->belongsTo(Profesor::class, 'tutor_id');
    }

    /**
     * Relación con el tutor (alias para profesorSupervisor)
     */
    public function tutor()
    {
        return $this->belongsTo(Profesor::class, 'tutor_id');
    }

    /**
     * Relación con el asesor académico
     */
    public function asesorAcademico()
    {
        return $this->belongsTo(Profesor::class, 'asesor_academico_id');
    }

    /**
     * Relación con documentos
     */
    public function documentos()
    {
        return $this->hasMany(Documento::class);
    }

    /**
     * Relación con citas
     */
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    /**
     * Scope para estadias activas
     */
    public function scopeActivas($query)
    {
        return $query->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca']);
    }

    /**
     * Scope para estadias por estatus
     */
    public function scopePorEstatus($query, $estatus)
    {
        return $query->where('status', $estatus);
    }

    /**
     * Scope para estadias en progreso
     */
    public function scopeEnProgreso($query)
    {
        return $query->where('status', 'en_proceso')
                    ->where('fecha_inicio', '<=', now())
                    ->where('fecha_fin', '>=', now());
    }

    /**
     * Scope para estadias completadas
     */
    public function scopeCompletadas($query)
    {
        return $query->where('status', 'finalizada');
    }

    /**
     * Scope para estadias por empresa
     */
    public function scopePorEmpresa($query, $empresaId)
    {
        return $query->where('empresa_id', $empresaId);
    }

    /**
     * Scope para estadias por especialidad
     */
    public function scopePorEspecialidad($query, $especialidadId)
    {
        return $query->where('especialidad_id', $especialidadId);
    }

    /**
     * Scope para estadias supervisadas por un profesor
     */
    public function scopeSupervisadasPor($query, $profesorId)
    {
        return $query->where('tutor_id', $profesorId);
    }

    /**
     * Scope para estadias asesoradas por un profesor
     */
    public function scopeAsesoradasPor($query, $profesorId)
    {
        return $query->where('asesor_academico_id', $profesorId);
    }

    /**
     * Obtener el porcentaje de progreso
     */
    public function getPorcentajeProgresoAttribute()
    {
        if ($this->horas_totales == 0) {
            return 0;
        }
        return round(($this->horas_completadas / $this->horas_totales) * 100, 2);
    }

    /**
     * Obtener las horas restantes
     */
    public function getHorasRestantesAttribute()
    {
        return max(0, $this->horas_totales - $this->horas_completadas);
    }

    /**
     * Obtener los días transcurridos
     */
    public function getDiasTranscurridosAttribute()
    {
        if (!$this->fecha_inicio) {
            return 0;
        }
        return $this->fecha_inicio->diffInDays(now());
    }

    /**
     * Obtener los días restantes
     */
    public function getDiasRestantesAttribute()
    {
        if (!$this->fecha_fin) {
            return null;
        }
        return now()->diffInDays($this->fecha_fin, false);
    }

    /**
     * Verificar si la estadia está vencida
     */
    public function getEstaVencidaAttribute()
    {
        return $this->fecha_fin && $this->fecha_fin < now() && $this->estatus !== 'completada';
    }

    /**
     * Obtener el estatus con formato legible
     */
    public function getEstatusFormateadoAttribute()
    {
        $estatusMap = [
            'pendiente' => 'Pendiente',
            'en_progreso' => 'En Progreso',
            'completada' => 'Completada',
            'cancelada' => 'Cancelada',
            'suspendida' => 'Suspendida'
        ];

        return $estatusMap[$this->estatus] ?? $this->estatus;
    }

    /**
     * Obtener documentos pendientes
     */
    public function getDocumentosPendientesAttribute()
    {
        return $this->documentos()->where('documentos.status', 'pendiente')->count();
    }

    /**
     * Obtener documentos aprobados
     */
    public function getDocumentosAprobadosAttribute()
    {
        return $this->documentos()->where('documentos.status', 'validado')->count();
    }
}