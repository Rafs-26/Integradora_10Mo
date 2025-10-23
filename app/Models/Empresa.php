<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'razon_social',
        'nombre_comercial',
        'rfc',
        'giro',
        'sector',
        'tamaño',
        'direccion',
        'ciudad',
        'estado',
        'codigo_postal',
        'telefono',
        'email',
        'sitio_web',
        'contacto_nombre',
        'contacto_puesto',
        'contacto_telefono',
        'contacto_email',
        'observaciones',
        'status',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Accessor para obtener el nombre de la empresa
     * Devuelve nombre_comercial si existe, sino razon_social
     */
    public function getNombreAttribute()
    {
        return $this->nombre_comercial ?: $this->razon_social;
    }

    /**
     * Relación con estadias
     */
    public function estadias()
    {
        return $this->hasMany(Estadia::class);
    }

    /**
     * Relación con estudiantes a través de estadias
     */
    public function estudiantes()
    {
        return $this->hasManyThrough(Estudiante::class, Estadia::class);
    }

    /**
     * Scope para empresas activas
     */
    public function scopeActivas($query)
    {
        return $query->where('status', 'activa');
    }

    /**
     * Scope para empresas con status específico
     */
    public function scopePorStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope para empresas por sector
     */
    public function scopePorSector($query, $sector)
    {
        return $query->where('sector', $sector);
    }

    /**
     * Scope para empresas por giro
     */
    public function scopePorGiro($query, $giro)
    {
        return $query->where('giro', $giro);
    }

    /**
     * Scope para empresas por tamaño
     */
    public function scopePorTamaño($query, $tamaño)
    {
        return $query->where('tamaño', $tamaño);
    }

    /**
     * Scope para empresas por ciudad
     */
    public function scopePorCiudad($query, $ciudad)
    {
        return $query->where('ciudad', $ciudad);
    }

    /**
     * Obtener el número de estadias activas
     */
    public function getEstadiasActivasAttribute()
    {
        return $this->estadias()->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])->count();
    }

    /**
     * Obtener el número total de estadias históricas
     */
    public function getTotalEstadiasAttribute()
    {
        return $this->estadias()->count();
    }

    /**
     * Verificar si la empresa está activa
     */
    public function getEsActivaAttribute()
    {
        return $this->status === 'activa';
    }



    /**
     * Obtener la dirección completa
     */
    public function getDireccionCompletaAttribute()
    {
        $direccion = $this->direccion;
        if ($this->ciudad) {
            $direccion .= ', ' . $this->ciudad;
        }
        if ($this->estado) {
            $direccion .= ', ' . $this->estado;
        }
        if ($this->codigo_postal) {
            $direccion .= ' ' . $this->codigo_postal;
        }
        return $direccion;
    }
}