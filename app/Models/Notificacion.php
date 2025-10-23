<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificaciones';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'tipo',
        'titulo',
        'mensaje',
        'datos_adicionales',
        'leida',
        'fecha_leida',
        'prioridad',
        'accion_requerida',
        'url_accion',
        'fecha_expiracion',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'datos_adicionales' => 'array',
        'leida' => 'boolean',
        'fecha_leida' => 'datetime',
        'accion_requerida' => 'boolean',
        'fecha_expiracion' => 'datetime',
    ];

    /**
     * Relación con el modelo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope para notificaciones no leídas
     */
    public function scopeNoLeidas($query)
    {
        return $query->where('leida', false);
    }

    /**
     * Scope para notificaciones leídas
     */
    public function scopeLeidas($query)
    {
        return $query->where('leida', true);
    }

    /**
     * Scope para notificaciones por tipo
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Scope para notificaciones por prioridad
     */
    public function scopePorPrioridad($query, $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    /**
     * Scope para notificaciones que requieren acción
     */
    public function scopeRequierenAccion($query)
    {
        return $query->where('accion_requerida', true);
    }

    /**
     * Scope para notificaciones vigentes (no expiradas)
     */
    public function scopeVigentes($query)
    {
        return $query->where(function($q) {
            $q->whereNull('fecha_expiracion')
              ->orWhere('fecha_expiracion', '>', now());
        });
    }

    /**
     * Scope para notificaciones expiradas
     */
    public function scopeExpiradas($query)
    {
        return $query->where('fecha_expiracion', '<=', now());
    }

    /**
     * Scope para notificaciones de hoy
     */
    public function scopeHoy($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope para notificaciones recientes (últimos 7 días)
     */
    public function scopeRecientes($query)
    {
        return $query->where('created_at', '>=', now()->subDays(7));
    }

    /**
     * Scope para notificaciones de un usuario específico
     */
    public function scopeDelUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Marcar la notificación como leída
     */
    public function marcarComoLeida()
    {
        $this->update([
            'leida' => true,
            'fecha_leida' => now()
        ]);
    }

    /**
     * Marcar la notificación como no leída
     */
    public function marcarComoNoLeida()
    {
        $this->update([
            'leida' => false,
            'fecha_leida' => null
        ]);
    }

    /**
     * Verificar si la notificación está expirada
     */
    public function getEstaExpiradaAttribute()
    {
        return $this->fecha_expiracion && $this->fecha_expiracion <= now();
    }

    /**
     * Obtener el tiempo transcurrido desde la creación
     */
    public function getTiempoTranscurridoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Obtener el icono según el tipo de notificación
     */
    public function getIconoAttribute()
    {
        $iconos = [
            'documento' => 'document-text',
            'cita' => 'calendar',
            'estadia' => 'briefcase',
            'sistema' => 'cog',
            'recordatorio' => 'bell',
            'evaluacion' => 'star',
            'mensaje' => 'chat-bubble-left',
            'alerta' => 'exclamation-triangle',
            'info' => 'information-circle',
            'exito' => 'check-circle',
            'error' => 'x-circle'
        ];

        return $iconos[$this->tipo] ?? 'bell';
    }

    /**
     * Obtener el color según la prioridad
     */
    public function getColorPrioridadAttribute()
    {
        $colores = [
            'baja' => 'blue',
            'media' => 'yellow',
            'alta' => 'orange',
            'critica' => 'red'
        ];

        return $colores[$this->prioridad] ?? 'gray';
    }

    /**
     * Obtener el tipo con formato legible
     */
    public function getTipoFormateadoAttribute()
    {
        $tipos = [
            'documento' => 'Documento',
            'cita' => 'Cita',
            'estadia' => 'Estadía',
            'sistema' => 'Sistema',
            'recordatorio' => 'Recordatorio',
            'evaluacion' => 'Evaluación',
            'mensaje' => 'Mensaje',
            'alerta' => 'Alerta',
            'info' => 'Información',
            'exito' => 'Éxito',
            'error' => 'Error'
        ];

        return $tipos[$this->tipo] ?? $this->tipo;
    }

    /**
     * Obtener la prioridad con formato legible
     */
    public function getPrioridadFormateadaAttribute()
    {
        $prioridades = [
            'baja' => 'Baja',
            'media' => 'Media',
            'alta' => 'Alta',
            'critica' => 'Crítica'
        ];

        return $prioridades[$this->prioridad] ?? $this->prioridad;
    }
}