<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relación con el modelo Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    /**
     * Relación uno a uno con Estudiante
     */
    public function estudiante()
    {
        return $this->hasOne(Estudiante::class, 'user_id');
    }

    /**
     * Relación uno a uno con Profesor
     */
    public function profesor()
    {
        return $this->hasOne(Profesor::class, 'user_id');
    }

    /**
     * Relación con notificaciones
     */
    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'usuario_id');
    }

    /**
     * Relación con logs de actividad
     */
    public function logsActividad()
    {
        return $this->hasMany(LogActividad::class, 'usuario_id');
    }

    /**
     * Verificar si el usuario tiene un rol específico
     */
    public function hasRole($roleName)
    {
        return $this->role && $this->role->nombre === $roleName;
    }

    /**
     * Obtener el nombre del rol del usuario
     */
    public function getRoleName()
    {
        return $this->role ? $this->role->nombre : null;
    }
}
