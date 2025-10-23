<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión para acceder a esta página.');
        }

        $user = Auth::user();
        
        // Verificar si el usuario tiene un rol asignado
        if (!$user->rol_id) {
            return redirect()->route('login')->with('error', 'Su cuenta no tiene un rol asignado. Contacte al administrador.');
        }

        // Obtener el rol del usuario con sus permisos
        $userRole = $user->role;
        
        if (!$userRole) {
            return redirect()->route('login')->with('error', 'Rol no encontrado. Contacte al administrador.');
        }

        // Si no se especifican roles, permitir acceso a cualquier usuario autenticado con rol
        if (empty($roles)) {
            return $next($request);
        }

        // Verificar si el usuario tiene uno de los roles requeridos
        if (in_array($userRole->nombre, $roles)) {
            return $next($request);
        }

        // Si el usuario no tiene el rol requerido, redirigir a su dashboard correspondiente
        return $this->redirectToDashboard($userRole->nombre);
    }

    /**
     * Redirigir al usuario a su dashboard correspondiente según su rol
     */
    private function redirectToDashboard(string $roleName)
    {
        $dashboardRoutes = [
            'Administrador' => 'admin.dashboard',
            'Director' => 'director.dashboard', 
            'Profesor' => 'teacher.dashboard',
            'Estudiante' => 'student.dashboard'
        ];

        $route = $dashboardRoutes[$roleName] ?? 'dashboard';
        
        return redirect()->route($route)->with('warning', 'No tiene permisos para acceder a esa sección.');
    }

    /**
     * Verificar si el usuario tiene un permiso específico
     */
    public static function hasPermission(string $permission): bool
    {
        if (!Auth::check()) {
            return false;
        }

        $user = Auth::user();
        $role = $user->role;

        if (!$role || !$role->permisos) {
            return false;
        }

        // Decodificar los permisos JSON
        $permissions = json_decode($role->permisos, true);
        
        if (!is_array($permissions)) {
            return false;
        }

        return in_array($permission, $permissions);
    }

    /**
     * Verificar si el usuario puede acceder a una funcionalidad específica
     */
    public static function canAccess(string $module, string $action = 'view'): bool
    {
        return self::hasPermission($module . '.' . $action);
    }
}