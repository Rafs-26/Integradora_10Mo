<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogActividad extends Model
{
    use HasFactory;

    protected $table = 'logs_actividad';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'usuario_id',
        'accion',
        'tabla_afectada',
        'registro_id',
        'descripcion',
        'datos_anteriores',
        'datos_nuevos',
        'ip_address',
        'user_agent',
        'nivel',
        'modulo',
        'session_id',
        'contexto_adicional',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'datos_anteriores' => 'array',
        'datos_nuevos' => 'array',
        'contexto_adicional' => 'array',
    ];

    /**
     * Relación con el modelo User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    /**
     * Relación polimórfica con el modelo afectado
     */
    public function modelo()
    {
        return $this->morphTo();
    }

    /**
     * Scope para logs por usuario
     */
    public function scopeDelUsuario($query, $userId)
    {
        return $query->where('usuario_id', $userId);
    }

    /**
     * Scope para logs por acción
     */
    public function scopePorAccion($query, $accion)
    {
        return $query->where('accion', $accion);
    }

    /**
     * Scope para logs por modelo
     */
    public function scopePorModelo($query, $modelo)
    {
        return $query->where('modelo', $modelo);
    }

    /**
     * Scope para logs por nivel
     */
    public function scopePorNivel($query, $nivel)
    {
        return $query->where('nivel', $nivel);
    }

    /**
     * Scope para logs por categoría
     */
    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    /**
     * Scope para logs exitosos
     */
    public function scopeExitosos($query)
    {
        return $query->where('exitoso', true);
    }

    /**
     * Scope para logs con errores
     */
    public function scopeConErrores($query)
    {
        return $query->where('exitoso', false);
    }

    /**
     * Scope para logs de hoy
     */
    public function scopeHoy($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope para logs de la última semana
     */
    public function scopeUltimaSemana($query)
    {
        return $query->where('created_at', '>=', now()->subWeek());
    }

    /**
     * Scope para logs del último mes
     */
    public function scopeUltimoMes($query)
    {
        return $query->where('created_at', '>=', now()->subMonth());
    }

    /**
     * Scope para logs en un rango de fechas
     */
    public function scopeEntreFechas($query, $fechaInicio, $fechaFin)
    {
        return $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
    }

    /**
     * Scope para logs por IP
     */
    public function scopePorIp($query, $ip)
    {
        return $query->where('ip_address', $ip);
    }

    /**
     * Scope para logs con tags específicos
     */
    public function scopeConTag($query, $tag)
    {
        return $query->whereJsonContains('tags', $tag);
    }

    /**
     * Scope para logs lentos (duración mayor a X ms)
     */
    public function scopeLentos($query, $duracionMs = 1000)
    {
        return $query->where('duracion_ms', '>', $duracionMs);
    }

    /**
     * Obtener el nombre del usuario que realizó la acción
     */
    public function getNombreUsuarioAttribute()
    {
        return $this->user ? $this->user->name : 'Sistema';
    }

    /**
     * Obtener el tiempo transcurrido desde la acción
     */
    public function getTiempoTranscurridoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Obtener la duración formateada
     */
    public function getDuracionFormateadaAttribute()
    {
        if (!$this->duracion_ms) {
            return null;
        }

        if ($this->duracion_ms < 1000) {
            return $this->duracion_ms . ' ms';
        }

        return round($this->duracion_ms / 1000, 2) . ' s';
    }

    /**
     * Obtener el icono según la acción
     */
    public function getIconoAttribute()
    {
        $iconos = [
            'crear' => 'plus-circle',
            'actualizar' => 'pencil',
            'eliminar' => 'trash',
            'ver' => 'eye',
            'login' => 'login',
            'logout' => 'logout',
            'exportar' => 'download',
            'importar' => 'upload',
            'enviar' => 'paper-airplane',
            'aprobar' => 'check-circle',
            'rechazar' => 'x-circle',
            'restaurar' => 'arrow-path',
        ];

        return $iconos[$this->accion] ?? 'document-text';
    }

    /**
     * Obtener el color según el nivel
     */
    public function getColorNivelAttribute()
    {
        $colores = [
            'debug' => 'gray',
            'info' => 'blue',
            'notice' => 'cyan',
            'warning' => 'yellow',
            'error' => 'red',
            'critical' => 'red',
            'alert' => 'red',
            'emergency' => 'red',
        ];

        return $colores[$this->nivel] ?? 'gray';
    }

    /**
     * Obtener la acción formateada
     */
    public function getAccionFormateadaAttribute()
    {
        $acciones = [
            'crear' => 'Crear',
            'actualizar' => 'Actualizar',
            'eliminar' => 'Eliminar',
            'ver' => 'Ver',
            'login' => 'Iniciar Sesión',
            'logout' => 'Cerrar Sesión',
            'exportar' => 'Exportar',
            'importar' => 'Importar',
            'enviar' => 'Enviar',
            'aprobar' => 'Aprobar',
            'rechazar' => 'Rechazar',
            'restaurar' => 'Restaurar',
        ];

        return $acciones[$this->accion] ?? ucfirst($this->accion);
    }

    /**
     * Obtener el nivel formateado
     */
    public function getNivelFormateadoAttribute()
    {
        $niveles = [
            'debug' => 'Debug',
            'info' => 'Información',
            'notice' => 'Aviso',
            'warning' => 'Advertencia',
            'error' => 'Error',
            'critical' => 'Crítico',
            'alert' => 'Alerta',
            'emergency' => 'Emergencia',
        ];

        return $niveles[$this->nivel] ?? ucfirst($this->nivel);
    }

    /**
     * Verificar si hay cambios en los datos
     */
    public function getHayCambiosAttribute()
    {
        return !empty($this->datos_anteriores) && !empty($this->datos_nuevos);
    }

    /**
     * Obtener los cambios realizados
     */
    public function getCambiosAttribute()
    {
        if (!$this->hay_cambios) {
            return [];
        }

        $cambios = [];
        $anteriores = $this->datos_anteriores ?? [];
        $nuevos = $this->datos_nuevos ?? [];

        foreach ($nuevos as $campo => $valorNuevo) {
            $valorAnterior = $anteriores[$campo] ?? null;
            if ($valorAnterior !== $valorNuevo) {
                $cambios[$campo] = [
                    'anterior' => $valorAnterior,
                    'nuevo' => $valorNuevo
                ];
            }
        }

        return $cambios;
    }

    /**
     * Métodos estáticos para crear logs
     */
    public static function registrar($accion, $descripcion, $datos = [])
    {
        return static::create(array_merge([
            'usuario_id' => auth()->id(),
            'accion' => $accion,
            'descripcion' => $descripcion,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'nivel' => 'info',
        ], $datos));
    }

    /**
     * Registrar error
     */
    public static function registrarError($accion, $descripcion, $error, $datos = [])
    {
        return static::create(array_merge([
            'usuario_id' => auth()->id(),
            'accion' => $accion,
            'descripcion' => $descripcion,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'nivel' => 'error',
        ], $datos));
    }

    /**
     * Registrar actividad (alias para registrar)
     */
    public static function registrarActividad($accion, $descripcion, $datos = [])
    {
        return static::registrar($accion, $descripcion, $datos);
    }
}