<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas_tutores';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tutor_id',
        'estudiante_id',
        'estadia_id',
        'titulo',
        'descripcion',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'modalidad',
        'ubicacion',
        'enlace_virtual',
        'status',
        'observaciones_tutor',
        'observaciones_estudiante',
        'fecha_confirmacion',
        'fecha_cancelacion',
        'motivo_cancelacion',
        'creado_por',
        'recordatorios',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha' => 'date',
        'hora_inicio' => 'string',
        'hora_fin' => 'string',
        'fecha_confirmacion' => 'datetime',
        'fecha_cancelacion' => 'datetime',
        'recordatorios' => 'array',
    ];

    /**
     * Relación con el modelo Estadia
     */
    public function estadia()
    {
        return $this->belongsTo(Estadia::class);
    }

    /**
     * Relación con el tutor (profesor)
     */
    public function tutor()
    {
        return $this->belongsTo(Profesor::class, 'tutor_id');
    }

    /**
     * Relación con el profesor (alias para tutor)
     */
    public function profesor()
    {
        return $this->tutor();
    }

    /**
     * Relación directa con el estudiante
     */
    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    /**
     * Relación con el usuario que creó la cita
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'creado_por');
    }

    /**
     * Scope para citas por estatus
     */
    public function scopePorEstatus($query, $estatus)
    {
        return $query->where('status', $estatus);
    }

    /**
     * Scope para citas programadas
     */
    public function scopeProgramadas($query)
    {
        return $query->where('status', 'programada');
    }

    /**
     * Scope para citas completadas
     */
    public function scopeCompletadas($query)
    {
        return $query->where('status', 'completada');
    }

    /**
     * Scope para citas canceladas
     */
    public function scopeCanceladas($query)
    {
        return $query->where('status', 'cancelada');
    }

    /**
     * Scope para citas por tipo
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_cita', $tipo);
    }

    /**
     * Scope para citas por modalidad
     */
    public function scopePorModalidad($query, $modalidad)
    {
        return $query->where('modalidad', $modalidad);
    }

    /**
     * Scope para citas de hoy
     */
    public function scopeHoy($query)
    {
        return $query->whereDate('fecha_hora', today());
    }

    /**
     * Scope para citas de esta semana
     */
    public function scopeEstaSemana($query)
    {
        return $query->whereBetween('fecha_hora', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Scope para citas próximas (siguientes 7 días)
     */
    public function scopeProximas($query)
    {
        return $query->whereBetween('fecha_hora', [
            now(),
            now()->addDays(7)
        ]);
    }

    /**
     * Scope para citas de un profesor específico
     */
    public function scopeDelProfesor($query, $profesorId)
    {
        return $query->where('profesor_id', $profesorId);
    }

    /**
     * Scope para citas que necesitan recordatorio
     */
    public function scopeNecesitanRecordatorio($query)
    {
        return $query->where('recordatorio_enviado', false)
                    ->where('fecha_hora', '>', now())
                    ->where('fecha_hora', '<=', now()->addHours(24))
                    ->where('status', 'programada');
    }

    /**
     * Accessor para obtener fecha y hora combinadas
     */
    public function getFechaHoraAttribute()
    {
        if ($this->fecha && $this->hora_inicio) {
            // Crear una nueva instancia Carbon con solo la fecha y agregar la hora
            return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->fecha->format('Y-m-d') . ' ' . $this->hora_inicio);
        }
        return null;
    }

    /**
     * Obtener la fecha y hora de fin de la cita
     */
    public function getFechaHoraFinAttribute()
    {
        if ($this->fecha && $this->hora_fin) {
            // Crear una nueva instancia Carbon con solo la fecha y agregar la hora
            return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->fecha->format('Y-m-d') . ' ' . $this->hora_fin);
        }
        return null;
    }

    /**
     * Verificar si la cita está en progreso
     */
    public function getEnProgresoAttribute()
    {
        $ahora = now();
        return $ahora >= $this->fecha_hora && $ahora <= $this->fecha_hora_fin;
    }

    /**
     * Verificar si la cita ya pasó
     */
    public function getYaPasoAttribute()
    {
        return now() > $this->fecha_hora_fin;
    }

    /**
     * Obtener minutos restantes para la cita
     */
    public function getMinutosRestantesAttribute()
    {
        if ($this->ya_paso) {
            return 0;
        }
        return now()->diffInMinutes($this->fecha_hora, false);
    }

    /**
     * Obtener el estatus con formato legible
     */
    public function getEstatusFormateadoAttribute()
    {
        $estatusMap = [
            'programada' => 'Programada',
            'en_progreso' => 'En Progreso',
            'completada' => 'Completada',
            'cancelada' => 'Cancelada',
            'reprogramada' => 'Reprogramada',
            'no_asistio' => 'No Asistió'
        ];

        return $estatusMap[$this->estatus] ?? $this->estatus;
    }

    /**
     * Obtener el tipo de cita con formato legible
     */
    public function getTipoCitaFormateadoAttribute()
    {
        $tiposMap = [
            'supervision' => 'Supervisión',
            'asesoria' => 'Asesoría',
            'revision_documento' => 'Revisión de Documento',
            'evaluacion' => 'Evaluación',
            'seguimiento' => 'Seguimiento',
            'reunion_inicial' => 'Reunión Inicial',
            'reunion_final' => 'Reunión Final'
        ];

        return $tiposMap[$this->tipo_cita] ?? $this->tipo_cita;
    }

    /**
     * Obtener la duración formateada
     */
    public function getDuracionFormateadaAttribute()
    {
        $horas = intval($this->duracion_minutos / 60);
        $minutos = $this->duracion_minutos % 60;
        
        if ($horas > 0) {
            return $horas . 'h ' . ($minutos > 0 ? $minutos . 'm' : '');
        }
        
        return $minutos . 'm';
    }
}