<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;

    protected $table = 'documentos';

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'estadia_id',
        'tipo_documento',
        'nombre_archivo',
        'ruta_archivo',
        'contenido_archivo',
        'tipo_mime',
        'tamaño_archivo',
        'hash_archivo',
        'version',
        'status',
        'fecha_subida',
        'subido_por',
        'fecha_validacion',
        'validado_por',
        'observaciones',
        'documento_anterior_id',
        'metadata',
    ];

    /**
     * Los atributos que deben ser convertidos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_subida' => 'datetime',
        'fecha_validacion' => 'datetime',
        'metadata' => 'array',
        'tamaño_archivo' => 'integer',
        'version' => 'integer',
    ];

    /**
     * Relación con el modelo Estadia
     */
    public function estadia()
    {
        return $this->belongsTo(Estadia::class);
    }

    /**
     * Relación con el estudiante a través de la estadía
     */
    public function estudiante()
    {
        return $this->hasOneThrough(
            Estudiante::class,
            Estadia::class,
            'id', // Foreign key on estadias table
            'id', // Foreign key on estudiantes table
            'estadia_id', // Local key on documentos table
            'estudiante_id' // Local key on estadias table
        );
    }

    /**
     * Relación con el profesor que revisó el documento
     */
    public function revisor()
    {
        return $this->belongsTo(Profesor::class, 'revisado_por');
    }

    /**
     * Scope para documentos por estatus
     */
    public function scopePorEstatus($query, $estatus)
    {
        return $query->where('status', $estatus);
    }

    /**
     * Scope para documentos pendientes
     */
    public function scopePendientes($query)
    {
        return $query->where('status', 'pendiente');
    }

    /**
     * Scope para documentos en revisión
     */
    public function scopeEnRevision($query)
    {
        return $query->where('status', 'revision');
    }

    /**
     * Scope para documentos aprobados
     */
    public function scopeAprobados($query)
    {
        return $query->where('status', 'validado');
    }

    /**
     * Scope para documentos rechazados
     */
    public function scopeRechazados($query)
    {
        return $query->where('status', 'rechazado');
    }

    /**
     * Scope para documentos obligatorios
     */
    public function scopeObligatorios($query)
    {
        return $query->where('es_obligatorio', true);
    }

    /**
     * Scope para documentos por tipo
     */
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo_documento', $tipo);
    }

    /**
     * Scope para documentos vencidos
     */
    public function scopeVencidos($query)
    {
        return $query->where('fecha_limite', '<', now())
                    ->whereNotIn('estatus', ['aprobado', 'entregado']);
    }

    /**
     * Verificar si el documento está vencido
     */
    public function getEstaVencidoAttribute()
    {
        return $this->fecha_limite && 
               $this->fecha_limite < now() && 
               !in_array($this->estatus, ['aprobado', 'entregado']);
    }

    /**
     * Obtener días restantes para la entrega
     */
    public function getDiasRestantesAttribute()
    {
        if (!$this->fecha_limite) {
            return null;
        }
        return now()->diffInDays($this->fecha_limite, false);
    }

    /**
     * Obtener el tamaño del archivo formateado
     */
    public function getTamañoFormateadoAttribute()
    {
        if (!$this->tamaño_archivo) {
            return null;
        }

        $bytes = $this->tamaño_archivo;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Obtener el estatus con formato legible
     */
    public function getEstatusFormateadoAttribute()
    {
        $estatusMap = [
            'pendiente' => 'Pendiente',
            'entregado' => 'Entregado',
            'en_revision' => 'En Revisión',
            'aprobado' => 'Aprobado',
            'rechazado' => 'Rechazado',
            'revision_requerida' => 'Revisión Requerida'
        ];

        return $estatusMap[$this->estatus] ?? $this->estatus;
    }

    /**
     * Obtener la URL del archivo
     */
    public function getUrlArchivoAttribute()
    {
        if (!$this->archivo_path) {
            return null;
        }
        return asset('storage/' . $this->archivo_path);
    }
}