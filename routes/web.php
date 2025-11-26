<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\BibliotecaController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\DirectorController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Dashboard Routes by Role
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('administrador.dashboard');
    })->name('admin.dashboard');
    Route::get('/admin/perfil', function () {
        return view('administrador.perfil');
    })->name('admin.perfil');
});

Route::middleware(['auth', 'role:Director'])->group(function () {
    Route::get('/director/dashboard', [DirectorController::class, 'dashboard'])->name('director.dashboard');
    Route::get('/director/perfil', function () {
        return view('director.perfil');
    })->name('director.perfil');
    
    // Gestión de Estadías
    Route::get('/director/estadias-activas', [DirectorController::class, 'estadiasActivas'])->name('director.estadias-activas');
    Route::get('/director/asignaciones', [DirectorController::class, 'asignaciones'])->name('director.asignaciones');
    Route::post('/director/asignaciones/crear', [DirectorController::class, 'crearAsignacion'])->name('director.asignaciones.crear');
    Route::get('/director/evaluaciones', [DirectorController::class, 'evaluaciones'])->name('director.evaluaciones');
    
    // Gestión de Estudiantes
    Route::get('/director/lista-estudiantes', [DirectorController::class, 'listaEstudiantes'])->name('director.lista-estudiantes');
    Route::post('/director/estudiantes/{estudiante}/asignar-profesor', [DirectorController::class, 'asignarProfesor'])->name('director.estudiantes.asignar-profesor');
    Route::get('/director/seguimiento-estudiantes', [DirectorController::class, 'seguimientoEstudiantes'])->name('director.seguimiento-estudiantes');
    
    // Gestión de Empresas
    Route::get('/director/empresas-colaboradoras', [DirectorController::class, 'empresasColaboradoras'])->name('director.empresas-colaboradoras');
    Route::get('/director/proyectos-disponibles', [DirectorController::class, 'proyectosDisponibles'])->name('director.proyectos-disponibles');
    
    // Gestión de Documentos
    Route::get('/director/documentos-pendientes', [DirectorController::class, 'documentosPendientes'])->name('director.documentos-pendientes');
    Route::get('/director/documentos-aprobados', [DirectorController::class, 'documentosAprobados'])->name('director.documentos-aprobados');
    Route::post('/director/documentos/{id}/aprobar', [DirectorController::class, 'aprobarDocumento'])->name('director.documentos.aprobar');
    Route::post('/director/documentos/{id}/rechazar', [DirectorController::class, 'rechazarDocumento'])->name('director.documentos.rechazar');
    
    // Cartas de Presentación
    Route::get('/director/cartas-pendientes', [DirectorController::class, 'cartasPendientes'])->name('director.cartas-pendientes');
Route::post('/director/cartas/{id}/aprobar', [DirectorController::class, 'aprobarCarta'])->name('director.cartas.aprobar');
Route::post('/director/cartas/{id}/rechazar', [DirectorController::class, 'rechazarCarta'])->name('director.cartas.rechazar');
Route::get('/director/cartas/{id}/generar-pdf', [DirectorController::class, 'generarPdfCarta'])->name('director.cartas.generar-pdf');
Route::post('/director/cartas/{id}/firmar', [DirectorController::class, 'firmarCarta'])->name('director.cartas.firmar');
Route::get('/director/cartas/{id}/descargar', [DirectorController::class, 'descargarCartaFirmada'])->name('director.cartas.descargar');
    
    // Reportes
    Route::get('/director/reportes', [DirectorController::class, 'reportes'])->name('director.reportes');
    Route::post('/director/reportes/generar-pdf', [DirectorController::class, 'generarReportePDF'])->name('director.reportes.generar-pdf');
});

Route::middleware(['auth', 'role:Profesor'])->group(function () {
    Route::get('/teacher/dashboard', [ProfesorController::class, 'dashboard'])->name('teacher.dashboard');
    Route::get('/teacher/mis-estudiantes', [ProfesorController::class, 'misEstudiantes'])->name('teacher.mis-estudiantes');
    Route::get('/teacher/seguimiento', [ProfesorController::class, 'seguimiento'])->name('teacher.seguimiento');
    Route::get('/teacher/evaluaciones', [ProfesorController::class, 'evaluaciones'])->name('teacher.evaluaciones');
    Route::get('/teacher/evaluaciones/crear', [ProfesorController::class, 'crearEvaluacion'])->name('teacher.evaluaciones.crear');
    Route::post('/teacher/evaluaciones/crear', [ProfesorController::class, 'crearEvaluacion'])->name('teacher.evaluaciones.store');
    Route::get('/teacher/documentos-por-revisar', [ProfesorController::class, 'documentosPorRevisar'])->name('teacher.documentos-por-revisar');
    Route::post('/teacher/documentos/{id}/revisar', [ProfesorController::class, 'revisarDocumento'])->name('teacher.documentos.revisar');
    Route::get('/teacher/documentos-revisados', [ProfesorController::class, 'documentosRevisados'])->name('teacher.documentos-revisados');
    Route::get('/teacher/formatos', [ProfesorController::class, 'formatos'])->name('teacher.formatos');
    Route::get('/teacher/formatos/descargar/{archivo}', [ProfesorController::class, 'descargarFormato'])->name('teacher.formatos.descargar');
    Route::get('/teacher/reportes', [ProfesorController::class, 'reportes'])->name('teacher.reportes');
    Route::get('/teacher/mensajes', [ProfesorController::class, 'mensajes'])->name('teacher.mensajes');
    Route::get('/teacher/programar-citas', [ProfesorController::class, 'programarCitas'])->name('teacher.programar-citas');
    Route::post('/teacher/citas/crear', [ProfesorController::class, 'crearCita'])->name('teacher.citas.crear');
    Route::patch('/teacher/citas/{id}/completar', [ProfesorController::class, 'completarCita'])->name('teacher.citas.completar');
    Route::put('/teacher/citas/{id}/editar', [ProfesorController::class, 'editarCita'])->name('teacher.citas.editar');
    Route::delete('/teacher/citas/{id}/cancelar', [ProfesorController::class, 'cancelarCita'])->name('teacher.citas.cancelar');
    Route::get('/teacher/perfil', [ProfesorController::class, 'perfil'])->name('teacher.perfil');
    Route::put('/teacher/perfil', [ProfesorController::class, 'actualizarPerfil'])->name('teacher.perfil.actualizar');
    // Rutas para solicitudes de cartas de presentación
    Route::get('/teacher/solicitudes-cartas', [ProfesorController::class, 'solicitudesCartas'])->name('teacher.solicitudes-cartas');
    Route::post('/teacher/solicitudes-cartas/{id}/aprobar', [ProfesorController::class, 'aprobarSolicitudCarta'])->name('teacher.solicitudes-cartas.aprobar');
    Route::post('/teacher/solicitudes-cartas/{id}/rechazar', [ProfesorController::class, 'rechazarSolicitudCarta'])->name('teacher.solicitudes-cartas.rechazar');
});

Route::middleware(['auth', 'role:Estudiante'])->group(function () {
    Route::get('/student/dashboard', [EstudianteController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/student/mi-estadia', [EstudianteController::class, 'miEstadia'])->name('student.mi-estadia');
    Route::get('/student/documentos', [EstudianteController::class, 'documentos'])->name('student.documentos');
    Route::post('/student/documentos/subir', [EstudianteController::class, 'subirDocumento'])->name('student.documentos.subir');
    Route::get('/student/documentos/descargar/{id}', [EstudianteController::class, 'descargarDocumento'])->name('student.documentos.descargar');
    Route::get('/student/citas', [EstudianteController::class, 'citas'])->name('student.citas');
    Route::post('/student/citas/agendar', [EstudianteController::class, 'agendarCita'])->name('student.citas.agendar');
    Route::patch('/student/citas/{id}/cancelar', [EstudianteController::class, 'cancelarCita'])->name('student.citas.cancelar');
    Route::get('/student/empresas', [EstudianteController::class, 'empresas'])->name('student.empresas');
    Route::post('/student/empresas/{empresa}/postular', [EstudianteController::class, 'postularEmpresa'])->name('student.empresas.postular');
    Route::get('/student/perfil', [EstudianteController::class, 'perfil'])->name('student.perfil');
Route::put('/student/perfil', [EstudianteController::class, 'actualizarPerfil'])->name('student.perfil.actualizar');
Route::post('/student/perfil/cambiar-password', [EstudianteController::class, 'cambiarPassword'])->name('student.perfil.cambiar-password');
Route::get('/student/carta-presentacion', [EstudianteController::class, 'cartaPresentacion'])->name('student.carta-presentacion');
Route::post('/student/carta-presentacion', [EstudianteController::class, 'storeCartaPresentacion'])->name('student.carta-presentacion.store');
Route::get('/student/carta-presentacion/solicitar', [EstudianteController::class, 'solicitarCartaPresentacion'])->name('student.carta-presentacion.solicitar');
Route::post('/student/carta-presentacion/solicitar', [EstudianteController::class, 'procesarSolicitudCarta'])->name('student.carta-presentacion.procesar');
Route::get('/student/estadia/editar-proyecto', [EstudianteController::class, 'editarProyecto'])->name('student.estadia.editar-proyecto');
Route::post('/student/estadia/actualizar-proyecto', [EstudianteController::class, 'actualizarProyecto'])->name('student.estadia.actualizar-proyecto');
Route::get('/student/carta-presentacion/descargar/{id}', [EstudianteController::class, 'descargarCartaPresentacion'])->name('student.carta-presentacion.descargar');
Route::get('/student/formatos-disponibles', [EstudianteController::class, 'formatosDisponibles'])->name('student.formatos-disponibles');
Route::get('/student/empresas-catalogo', [EstudianteController::class, 'empresasCatalogo'])->name('student.empresas-catalogo');
});

Route::middleware(['auth', 'role:Biblioteca'])->group(function () {
    Route::get('/biblioteca/dashboard', function () {
        return view('biblioteca.dashboard');
    })->name('biblioteca.dashboard');
    Route::get('/biblioteca/perfil', function () {
        return view('biblioteca.perfil');
    })->name('biblioteca.perfil');
});

// General Dashboard Route (redirects based on role)
Route::get('/dashboard', [AuthController::class, 'redirectToDashboard'])->middleware('auth')->name('dashboard');

// Notification Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'getUserNotifications'])->name('notifications.get');
    Route::get('/notifications/count', [NotificationController::class, 'getUnreadCount'])->name('notifications.count');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/notifications/role/{roleName}', [NotificationController::class, 'getNotificationsByRole'])->name('notifications.role');
});

// Admin-only notification creation routes
Route::middleware(['auth', 'role:Administrador'])->group(function () {
    Route::post('/notifications/create/role', [NotificationController::class, 'createRoleNotification'])->name('notifications.create.role');
    Route::post('/notifications/create/user', [NotificationController::class, 'createUserNotification'])->name('notifications.create.user');
    Route::post('/notifications/create/global', [NotificationController::class, 'createGlobalNotification'])->name('notifications.create.global');
});

// Rutas para Biblioteca
    Route::middleware(['role:Biblioteca'])->prefix('biblioteca')->name('biblioteca.')->group(function () {
        Route::get('/dashboard', [BibliotecaController::class, 'dashboard'])->name('dashboard');
        Route::get('/memorias-pendientes', [BibliotecaController::class, 'memoriasPendientes'])->name('memorias-pendientes');
        Route::get('/memorias-validadas', [BibliotecaController::class, 'memoriasValidadas'])->name('memorias-validadas');
        Route::get('/memorias-rechazadas', [BibliotecaController::class, 'memoriasRechazadas'])->name('memorias-rechazadas');
        Route::get('/revisar-memoria/{id}', [BibliotecaController::class, 'revisarMemoria'])->name('revisar-memoria');
        Route::post('/validar-memoria/{id}', [BibliotecaController::class, 'validarMemoria'])->name('validar-memoria');
        Route::post('/rechazar-memoria/{id}', [BibliotecaController::class, 'rechazarMemoria'])->name('rechazar-memoria');
        Route::post('/reactivar-memoria/{id}', [BibliotecaController::class, 'reactivarMemoria'])->name('reactivar-memoria');
        Route::get('/descargar-memoria/{id}', [BibliotecaController::class, 'descargarMemoria'])->name('descargar-memoria');
        Route::get('/estadisticas', [BibliotecaController::class, 'estadisticas'])->name('estadisticas');
    });

// Test Navigation Route
Route::get('/test-navigation', function () {
    return view('test-navigation');
})->middleware('auth')->name('test.navigation');
