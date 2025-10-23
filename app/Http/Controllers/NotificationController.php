<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notificacion;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Obtener notificaciones del usuario autenticado
     */
    public function getUserNotifications()
    {
        $user = Auth::user();
        
        // Obtener notificaciones específicas del usuario
        $notifications = Notificacion::where('usuario_id', $user->id)
            ->where('activa', true)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return response()->json($notifications);
    }
    
    /**
     * Marcar notificación como leída
     */
    public function markAsRead($id)
    {
        $notification = Notificacion::findOrFail($id);
        $user = Auth::user();
        
        // Verificar que el usuario puede marcar esta notificación
        if ($notification->usuario_id == $user->id) {
            $notification->update(['leida' => true, 'fecha_leida' => Carbon::now()]);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['error' => 'No autorizado'], 403);
    }
    
    /**
     * Obtener contador de notificaciones no leídas
     */
    public function getUnreadCount()
    {
        $user = Auth::user();
        
        $count = Notificacion::where('usuario_id', $user->id)
            ->where('leida', false)
            ->where('activa', true)
            ->count();
        
        return response()->json(['count' => $count]);
    }
    
    /**
     * Crear notificación específica por rol
     */
    public function createRoleNotification(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'mensaje' => 'required|string',
            'tipo' => 'required|string|in:info,warning,error,success,cita,documento,estadia,sistema,recordatorio',
            'role_id' => 'required|exists:roles,id',
            'prioridad' => 'sometimes|string|in:baja,media,alta,urgente'
        ]);
        
        // Obtener todos los usuarios con el rol especificado
        $users = \App\Models\User::where('rol_id', $request->role_id)->get();
        $createdNotifications = [];
        
        foreach ($users as $user) {
            $notification = Notificacion::create([
                'usuario_id' => $user->id,
                'titulo' => $request->titulo,
                'mensaje' => $request->mensaje,
                'tipo' => $request->tipo,
                'prioridad' => $request->prioridad ?? 'media',
                'leida' => false,
                'enviado_por' => Auth::id(),
                'activa' => true
            ]);
            $createdNotifications[] = $notification;
        }
        
        return response()->json([
            'success' => true, 
            'message' => 'Notificaciones creadas para ' . count($createdNotifications) . ' usuarios',
            'count' => count($createdNotifications)
        ]);
    }
    
    /**
     * Crear notificación para usuario específico
     */
    public function createUserNotification(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'mensaje' => 'required|string',
            'tipo' => 'required|string|in:info,warning,error,success,cita,documento,estadia,sistema,recordatorio',
            'user_id' => 'required|exists:users,id',
            'prioridad' => 'sometimes|string|in:baja,media,alta,urgente'
        ]);
        
        $notification = Notificacion::create([
            'usuario_id' => $request->user_id,
            'titulo' => $request->titulo,
            'mensaje' => $request->mensaje,
            'tipo' => $request->tipo,
            'prioridad' => $request->prioridad ?? 'media',
            'leida' => false,
            'enviado_por' => Auth::id(),
            'activa' => true
        ]);
        
        return response()->json(['success' => true, 'notification' => $notification]);
    }
    
    /**
     * Crear notificación para todos los usuarios
     */
    public function createGlobalNotification(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:200',
            'mensaje' => 'required|string',
            'tipo' => 'required|string|in:info,warning,error,success,cita,documento,estadia,sistema,recordatorio',
            'prioridad' => 'sometimes|string|in:baja,media,alta,urgente'
        ]);
        
        // Obtener todos los usuarios activos
        $users = User::all();
        $notifications = [];
        
        foreach ($users as $user) {
            $notification = Notificacion::create([
                'usuario_id' => $user->id,
                'titulo' => $request->titulo,
                'mensaje' => $request->mensaje,
                'tipo' => $request->tipo,
                'prioridad' => $request->prioridad ?? 'media',
                'leida' => false,
                'enviado_por' => Auth::id(),
                'activa' => true
            ]);
            $notifications[] = $notification;
        }
        
        return response()->json([
            'success' => true, 
            'message' => 'Notificación global creada para ' . count($notifications) . ' usuarios',
            'notifications_count' => count($notifications)
        ]);
    }
    
    /**
     * Obtener notificaciones específicas por rol
     */
    public function getNotificationsByRole($roleName)
    {
        $user = Auth::user();
        
        // Verificar que el usuario tenga permisos para ver notificaciones de este rol
        if ($user->role->nombre !== 'Administrador' && $user->role->nombre !== $roleName) {
            return response()->json(['error' => 'No autorizado'], 403);
        }
        
        $notifications = [];
        
        switch ($roleName) {
            case 'Administrador':
                $notifications = $this->getAdminNotifications();
                break;
            case 'Director':
                $notifications = $this->getDirectorNotifications();
                break;
            case 'Profesor':
                $notifications = $this->getTeacherNotifications();
                break;
            case 'Estudiante':
                $notifications = $this->getStudentNotifications();
                break;
            case 'Biblioteca':
                $notifications = $this->getLibraryNotifications();
                break;
        }
        
        return response()->json($notifications);
    }
    
    /**
     * Notificaciones específicas para Administrador
     */
    private function getAdminNotifications()
    {
        return [
            [
                'titulo' => 'Reporte del Sistema',
                'mensaje' => 'Resumen semanal de actividades del sistema disponible',
                'tipo' => 'info',
                'fecha' => Carbon::now()->subHours(2)->format('Y-m-d H:i:s')
            ],
            [
                'titulo' => 'Nuevo Usuario Registrado',
                'mensaje' => 'Se ha registrado un nuevo profesor en el sistema',
                'tipo' => 'success',
                'fecha' => Carbon::now()->subHours(5)->format('Y-m-d H:i:s')
            ],
            [
                'titulo' => 'Mantenimiento Programado',
                'mensaje' => 'El sistema tendrá mantenimiento el próximo domingo',
                'tipo' => 'warning',
                'fecha' => Carbon::now()->subDay()->format('Y-m-d H:i:s')
            ]
        ];
    }
    
    /**
     * Notificaciones específicas para Director
     */
    private function getDirectorNotifications()
    {
        return [
            [
                'titulo' => 'Estadías Pendientes',
                'mensaje' => 'Hay 5 estadías pendientes de aprobación',
                'tipo' => 'warning',
                'fecha' => Carbon::now()->subHour()->format('Y-m-d H:i:s')
            ],
            [
                'titulo' => 'Reporte Mensual',
                'mensaje' => 'Reporte mensual de estadías completadas disponible',
                'tipo' => 'info',
                'fecha' => Carbon::now()->subHours(3)->format('Y-m-d H:i:s')
            ],
            [
                'titulo' => 'Reunión Programada',
                'mensaje' => 'Reunión con coordinadores académicos mañana a las 10:00 AM',
                'tipo' => 'info',
                'fecha' => Carbon::now()->subHours(6)->format('Y-m-d H:i:s')
            ]
        ];
    }
    
    /**
     * Notificaciones específicas para Profesor
     */
    private function getTeacherNotifications()
    {
        return [
            [
                'titulo' => 'Estudiante Asignado',
                'mensaje' => 'Se te ha asignado un nuevo estudiante para asesoría',
                'tipo' => 'success',
                'fecha' => Carbon::now()->subMinutes(30)->format('Y-m-d H:i:s')
            ],
            [
                'titulo' => 'Documento Pendiente',
                'mensaje' => 'Tienes 2 documentos de estadía pendientes de revisión',
                'tipo' => 'warning',
                'fecha' => Carbon::now()->subHours(2)->format('Y-m-d H:i:s')
            ],
            [
                'titulo' => 'Capacitación Disponible',
                'mensaje' => 'Nueva capacitación sobre evaluación de estadías disponible',
                'tipo' => 'info',
                'fecha' => Carbon::now()->subHours(4)->format('Y-m-d H:i:s')
            ]
        ];
    }
    
    /**
     * Notificaciones específicas para Estudiante
     */
    private function getStudentNotifications()
    {
        return [
            [
                'titulo' => 'Documento Aprobado',
                'mensaje' => 'Tu propuesta de estadía ha sido aprobada',
                'tipo' => 'success',
                'fecha' => Carbon::now()->subMinutes(15)->format('Y-m-d H:i:s')
            ],
            [
                'titulo' => 'Cita Programada',
                'mensaje' => 'Tienes una cita con tu asesor mañana a las 2:00 PM',
                'tipo' => 'info',
                'fecha' => Carbon::now()->subHour()->format('Y-m-d H:i:s')
            ],
            [
                'titulo' => 'Fecha Límite',
                'mensaje' => 'Recuerda entregar tu reporte semanal antes del viernes',
                'tipo' => 'warning',
                'fecha' => Carbon::now()->subHours(3)->format('Y-m-d H:i:s')
            ]
        ];
    }
    
    /**
     * Notificaciones específicas para Biblioteca
     */
    private function getLibraryNotifications()
    {
        return [
            [
                'titulo' => 'Memoria Recibida',
                'mensaje' => 'Nueva memoria de estadía recibida para validación',
                'tipo' => 'info',
                'fecha' => Carbon::now()->subMinutes(45)->format('Y-m-d H:i:s')
            ],
            [
                'titulo' => 'Validaciones Pendientes',
                'mensaje' => 'Tienes 3 memorias pendientes de validación',
                'tipo' => 'warning',
                'fecha' => Carbon::now()->subHours(2)->format('Y-m-d H:i:s')
            ],
            [
                'titulo' => 'Proceso Completado',
                'mensaje' => 'Memoria de Juan Pérez validada exitosamente',
                'tipo' => 'success',
                'fecha' => Carbon::now()->subHours(4)->format('Y-m-d H:i:s')
            ]
        ];
    }
}