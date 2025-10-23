<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Notificacion;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;

class NotificacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener roles
        $adminRole = Role::where('nombre', 'Administrador')->first();
        $directorRole = Role::where('nombre', 'Director')->first();
        $profesorRole = Role::where('nombre', 'Profesor')->first();
        $estudianteRole = Role::where('nombre', 'Estudiante')->first();
        $bibliotecaRole = Role::where('nombre', 'Biblioteca')->first();
        
        // Obtener usuarios por rol para crear notificaciones personalizadas
        $administradores = User::where('rol_id', $adminRole?->id)->get();
        $directores = User::where('rol_id', $directorRole?->id)->get();
        $profesores = User::where('rol_id', $profesorRole?->id)->get();
        $estudiantes = User::where('rol_id', $estudianteRole?->id)->get();
        $bibliotecarios = User::where('rol_id', $bibliotecaRole?->id)->get();
        
        // Notificaciones para Administradores
        foreach ($administradores as $admin) {
            Notificacion::create([
                'usuario_id' => $admin->id,
                'titulo' => 'Reporte del Sistema',
                'mensaje' => 'Resumen semanal de actividades del sistema disponible',
                'tipo' => 'sistema',
                'prioridad' => 'media',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);

            Notificacion::create([
                'usuario_id' => $admin->id,
                'titulo' => 'Nuevo Usuario Registrado',
                'mensaje' => 'Se ha registrado un nuevo profesor en el sistema',
                'tipo' => 'info',
                'prioridad' => 'media',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);
            
            Notificacion::create([
                'usuario_id' => $admin->id,
                'titulo' => 'Mantenimiento Programado',
                'mensaje' => 'El sistema tendrá mantenimiento el próximo domingo',
                'tipo' => 'warning',
                'prioridad' => 'alta',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);
        }
        
        // Notificaciones para Directores
        foreach ($directores as $director) {
            Notificacion::create([
                'usuario_id' => $director->id,
                'titulo' => 'Estadías Pendientes',
                'mensaje' => 'Hay 5 estadías pendientes de aprobación',
                'tipo' => 'warning',
                'prioridad' => 'alta',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);
            
            Notificacion::create([
                'usuario_id' => $director->id,
                'titulo' => 'Reporte Mensual',
                'mensaje' => 'Reporte mensual de estadías completadas disponible',
                'tipo' => 'info',
                'prioridad' => 'media',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);
            
            Notificacion::create([
                'usuario_id' => $director->id,
                'titulo' => 'Reunión Programada',
                'mensaje' => 'Reunión con coordinadores académicos mañana a las 10:00 AM',
                'tipo' => 'info',
                'prioridad' => 'media',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);
        }
        
        // Notificaciones para Profesores
        foreach ($profesores as $profesor) {
            Notificacion::create([
                'usuario_id' => $profesor->id,
                'titulo' => 'Estudiante Asignado',
                'mensaje' => 'Se te ha asignado un nuevo estudiante para asesoría',
                'tipo' => 'success',
                'prioridad' => 'media',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);
            
            Notificacion::create([
                'usuario_id' => $profesor->id,
                'titulo' => 'Documento Pendiente',
                'mensaje' => 'Tienes 2 documentos de estadía pendientes de revisión',
                'tipo' => 'warning',
                'prioridad' => 'alta',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);
            
            Notificacion::create([
                'usuario_id' => $profesor->id,
                'titulo' => 'Capacitación Disponible',
                'mensaje' => 'Nueva capacitación sobre evaluación de estadías disponible',
                'tipo' => 'info',
                'prioridad' => 'baja',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);
        }
        
        // Notificaciones para Estudiantes
        foreach ($estudiantes as $estudiante) {
            Notificacion::create([
                'usuario_id' => $estudiante->id,
                'titulo' => 'Documento Aprobado',
                'mensaje' => 'Tu propuesta de estadía ha sido aprobada',
                'tipo' => 'success',
                'prioridad' => 'alta',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);
            
            Notificacion::create([
                'usuario_id' => $estudiante->id,
                'titulo' => 'Cita Programada',
                'mensaje' => 'Tienes una cita con tu asesor mañana a las 2:00 PM',
                'tipo' => 'info',
                'prioridad' => 'media',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);
            
            Notificacion::create([
                'usuario_id' => $estudiante->id,
                'titulo' => 'Fecha Límite',
                'mensaje' => 'Recuerda entregar tu reporte semanal antes del viernes',
                'tipo' => 'warning',
                'prioridad' => 'alta',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);
        }
        
        // Notificaciones para Bibliotecarios
        foreach ($bibliotecarios as $bibliotecario) {
            Notificacion::create([
                'usuario_id' => $bibliotecario->id,
                'titulo' => 'Memoria Recibida',
                'mensaje' => 'Nueva memoria de estadía recibida para validación',
                'tipo' => 'info',
                'prioridad' => 'media',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);
            
            Notificacion::create([
                'usuario_id' => $bibliotecario->id,
                'titulo' => 'Validaciones Pendientes',
                'mensaje' => 'Tienes 3 memorias pendientes de validación',
                'tipo' => 'warning',
                'prioridad' => 'alta',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);
            
            Notificacion::create([
                'usuario_id' => $bibliotecario->id,
                'titulo' => 'Proceso Completado',
                'mensaje' => 'Memoria de Juan Pérez validada exitosamente',
                'tipo' => 'success',
                'prioridad' => 'baja',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);
        }
        
        // Crear algunas notificaciones adicionales para usuarios específicos
        $primerEstudiante = $estudiantes->first();
        if ($primerEstudiante) {
            Notificacion::create([
                'usuario_id' => $primerEstudiante->id,
                'titulo' => 'Notificación Personal',
                'mensaje' => 'Tu asesor ha programado una reunión individual contigo',
                'tipo' => 'info',
                'prioridad' => 'alta',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);
        }
        
        $primerProfesor = $profesores->first();
        if ($primerProfesor) {
            Notificacion::create([
                'usuario_id' => $primerProfesor->id,
                'titulo' => 'Evaluación Pendiente',
                'mensaje' => 'El estudiante María García ha subido su reporte final',
                'tipo' => 'warning',
                'prioridad' => 'alta',
                'leida' => false,
                'enviado_por' => null,
                'activa' => true,
            ]);
        }
        
        $this->command->info('✅ Notificaciones de ejemplo creadas exitosamente');
        $this->command->info('📧 Se crearon notificaciones individuales para cada usuario:');
        $this->command->info('   - Administradores: ' . ($administradores->count() * 3) . ' notificaciones');
        $this->command->info('   - Directores: ' . ($directores->count() * 3) . ' notificaciones');
        $this->command->info('   - Profesores: ' . ($profesores->count() * 3) . ' notificaciones');
        $this->command->info('   - Estudiantes: ' . ($estudiantes->count() * 3) . ' notificaciones');
        $this->command->info('   - Bibliotecarios: ' . ($bibliotecarios->count() * 3) . ' notificaciones');
        $this->command->info('   - Notificaciones adicionales: 2');
    }
}