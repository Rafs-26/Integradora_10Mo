<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionSistema extends Model
{
    use HasFactory;

    protected $table = 'configuracion_sistema';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'clave',
        'valor',
        'tipo',
        'descripcion',
        'categoria',
        'es_publica',
        'requiere_reinicio',
        'valor_por_defecto',
        'opciones_validas',
        'activa',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'es_publica' => 'boolean',
        'requiere_reinicio' => 'boolean',
        'activa' => 'boolean',
        'opciones_validas' => 'array',
    ];

    /**
     * Scope para configuraciones activas
     */
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }

    /**
     * Scope para configuraciones públicas
     */
    public function scopePublicas($query)
    {
        return $query->where('es_publica', true);
    }

    /**
     * Scope para configuraciones por categoría
     */
    public function scopePorCategoria($query, $categoria)
    {
        return $query->where('categoria', $categoria);
    }

    /**
     * Scope para configuraciones por tipo
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Obtener el valor convertido según el tipo
     */
    public function getValorConvertidoAttribute()
    {
        switch ($this->tipo) {
            case 'boolean':
                return filter_var($this->valor, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $this->valor;
            case 'float':
                return (float) $this->valor;
            case 'array':
            case 'json':
                return json_decode($this->valor, true);
            case 'string':
            default:
                return $this->valor;
        }
    }

    /**
     * Establecer el valor según el tipo
     */
    public function setValorAttribute($value)
    {
        switch ($this->tipo) {
            case 'array':
            case 'json':
                $this->attributes['valor'] = is_string($value) ? $value : json_encode($value);
                break;
            case 'boolean':
                $this->attributes['valor'] = $value ? '1' : '0';
                break;
            default:
                $this->attributes['valor'] = (string) $value;
        }
    }

    /**
     * Validar si el valor es válido según las opciones
     */
    public function esValorValido($valor)
    {
        if (empty($this->opciones_validas)) {
            return true;
        }

        return in_array($valor, $this->opciones_validas);
    }

    /**
     * Obtener el valor por defecto convertido
     */
    public function getValorPorDefectoConvertidoAttribute()
    {
        if (!$this->valor_por_defecto) {
            return null;
        }

        switch ($this->tipo) {
            case 'boolean':
                return filter_var($this->valor_por_defecto, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $this->valor_por_defecto;
            case 'float':
                return (float) $this->valor_por_defecto;
            case 'array':
            case 'json':
                return json_decode($this->valor_por_defecto, true);
            case 'string':
            default:
                return $this->valor_por_defecto;
        }
    }

    /**
     * Restaurar al valor por defecto
     */
    public function restaurarPorDefecto()
    {
        if ($this->valor_por_defecto !== null) {
            $this->valor = $this->valor_por_defecto;
            $this->save();
        }
    }

    /**
     * Métodos estáticos para obtener configuraciones comunes
     */
    public static function obtener($clave, $valorPorDefecto = null)
    {
        $config = static::where('clave', $clave)->where('activa', true)->first();
        
        if (!$config) {
            return $valorPorDefecto;
        }
        
        return $config->valor_convertido;
    }

    /**
     * Establecer una configuración
     */
    public static function establecer($clave, $valor, $tipo = 'string')
    {
        $config = static::firstOrNew(['clave' => $clave]);
        $config->tipo = $tipo;
        $config->valor = $valor;
        $config->activa = true;
        $config->save();
        
        return $config;
    }

    /**
     * Obtener todas las configuraciones públicas
     */
    public static function obtenerPublicas()
    {
        return static::publicas()->activas()->get()->mapWithKeys(function ($config) {
            return [$config->clave => $config->valor_convertido];
        });
    }

    /**
     * Obtener configuraciones por categoría
     */
    public static function obtenerPorCategoria($categoria)
    {
        return static::porCategoria($categoria)->activas()->get()->mapWithKeys(function ($config) {
            return [$config->clave => $config->valor_convertido];
        });
    }

    /**
     * Verificar si existe una configuración
     */
    public static function existe($clave)
    {
        return static::where('clave', $clave)->where('activa', true)->exists();
    }

    /**
     * Eliminar una configuración
     */
    public static function eliminar($clave)
    {
        return static::where('clave', $clave)->delete();
    }

    /**
     * Obtener configuraciones que requieren reinicio
     */
    public static function obtenerQueRequierenReinicio()
    {
        return static::where('requiere_reinicio', true)->activas()->get();
    }
}