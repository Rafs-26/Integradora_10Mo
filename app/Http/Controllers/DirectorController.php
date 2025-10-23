<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Estadia;
use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\Empresa;
use App\Models\Documento;
use App\Models\SolicitudCartaPresentacion;
use App\Models\User;
use App\Models\Carrera;
use App\Models\AsignacionTutor;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DirectorController extends Controller
{
    /**
     * Dashboard principal del director
     */
    public function dashboard()
    {
        $user = Auth::user();
        $director = $user->profesor;
        
        // Estadísticas generales
        $stats = [
            'estadias_activas' => Estadia::where('status', 'activa')->count(),
            'estudiantes_asignados' => Estudiante::whereHas('estadias', function($query) {
                $query->where('status', 'activa');
            })->count(),
            'documentos_pendientes' => Documento::where('status', 'pendiente')->count(),
            'cartas_pendientes' => SolicitudCartaPresentacion::where('estado', 'aprobada_profesor')->count(),
            'empresas_colaboradoras' => Empresa::where('status', 'activa')->count(),
            'profesores_activos' => Profesor::where('activo_como_tutor', true)->count()
        ];
        
        // Estadías recientes
        $estadiasRecientes = Estadia::with(['estudiante.user', 'empresa', 'profesorSupervisor.user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Documentos pendientes de revisión
        $documentosPendientes = Documento::with(['estudiante.user', 'estadia.empresa'])
            ->where('status', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Cartas de presentación pendientes de aprobación del director
        $cartasPendientes = SolicitudCartaPresentacion::with(['estudiante.user', 'revisadaPorProfesor'])
            ->where('estado', 'aprobada_profesor')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('director.dashboard', compact(
            'user', 
            'director', 
            'stats', 
            'estadiasRecientes', 
            'documentosPendientes',
            'cartasPendientes'
        ));
    }
    
    /**
     * Mostrar estadías activas
     */
    public function estadiasActivas()
    {
        $estadias = Estadia::with(['estudiante.user', 'empresa', 'profesorSupervisor.user'])
            ->where('status', 'activa')
            ->orderBy('fecha_inicio', 'desc')
            ->paginate(15);
            
        // Estadísticas para la vista
        $stats = [
            'total_activas' => Estadia::where('status', 'activa')->count(),
            'por_vencer' => Estadia::where('status', 'activa')
                ->where('fecha_fin', '<=', now()->addDays(30))
                ->count(),
            'progreso_promedio' => $this->calcularProgresoPromedio(),
            'con_problemas' => Estadia::where('status', 'activa')
                ->where('observaciones', '!=', null)
                ->where('observaciones', '!=', '')
                ->count()
        ];
        
        // Datos para filtros
        $empresas = Empresa::where('status', 'activa')->orderBy('razon_social')->get();
        $carreras = Carrera::orderBy('nombre')->get();
        $profesores = Profesor::with('user')
            ->where('activo_como_tutor', true)
            ->get();
            
        return view('director.estadias-activas', compact('estadias', 'stats', 'empresas', 'carreras', 'profesores'));
    }
    
    /**
     * Mostrar asignaciones de estudiantes a profesores
     */
    public function asignaciones()
    {
        $asignaciones = Estadia::with(['estudiante.user', 'profesorSupervisor.user', 'empresa'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        $profesores = Profesor::with('user')
            ->where('activo_como_tutor', true)
            ->get();
            
        $estudiantes = Estudiante::with('user')
            ->whereDoesntHave('estadias')
            ->get();
            
        $empresas = Empresa::where('status', 'activa')
            ->orderBy('razon_social')
            ->get();
            
        return view('director.asignaciones', compact('asignaciones', 'profesores', 'estudiantes', 'empresas'));
    }
    
    /**
     * Mostrar evaluaciones
     */
    public function evaluaciones()
    {
        $evaluaciones = DB::table('evaluaciones')
            ->join('estudiantes', 'evaluaciones.estudiante_id', '=', 'estudiantes.id')
            ->join('users', 'estudiantes.user_id', '=', 'users.id')
            ->join('profesores', 'evaluaciones.evaluador_id', '=', 'profesores.id')
            ->join('users as prof_users', 'profesores.user_id', '=', 'prof_users.id')
            ->select(
                'evaluaciones.*',
                'users.name as estudiante_nombre',
                'prof_users.name as profesor_nombre'
            )
            ->orderBy('evaluaciones.created_at', 'desc')
            ->paginate(15);
            
        return view('director.evaluaciones', compact('evaluaciones'));
    }
    
    /**
     * Lista de estudiantes
     */
    public function listaEstudiantes()
    {
        $estudiantes = Estudiante::with([
                'user', 
                'carrera', 
                'especialidad', 
                'estadia.empresa',
                'estadia.profesorSupervisor.user',
                'asignacionTutorActiva.tutor.user'
            ])
            ->orderBy('matricula')
            ->paginate(15);
            
        $profesores = Profesor::with('user')
            ->where('activo_como_tutor', true)
            ->get();
            
        $carreras = Carrera::orderBy('nombre')->get();
            
        return view('director.lista-estudiantes', compact('estudiantes', 'profesores', 'carreras'));
    }
    
    /**
     * Asignar profesor a estudiante
     */
    public function asignarProfesor(Request $request, Estudiante $estudiante)
    {
        $request->validate([
            'profesor_id' => 'required|exists:profesores,id'
        ]);
        
        $profesor = Profesor::findOrFail($request->profesor_id);
        
        // Verificar si el estudiante ya tiene una asignación activa
        $asignacionExistente = AsignacionTutor::where('estudiante_id', $estudiante->id)
            ->where('status', 'activa')
            ->first();
            
        if ($asignacionExistente) {
            // Actualizar la asignación existente
            $asignacionExistente->update([
                'tutor_id' => $profesor->id,
                'updated_at' => now()
            ]);
        } else {
            // Crear nueva asignación
            AsignacionTutor::create([
                'tutor_id' => $profesor->id,
                'estudiante_id' => $estudiante->id,
                'carrera_id' => $estudiante->carrera_id,
                'director_id' => auth()->user()->director->id ?? 1, // Usar el director actual
                'periodo' => date('Y') . '-' . (date('Y') + 1),
                'status' => 'activa'
            ]);
        }
        
        return redirect()->route('director.lista-estudiantes')
            ->with('success', 'Profesor asignado exitosamente al estudiante ' . $estudiante->user->name);
    }
    
    /**
     * Seguimiento de estudiantes
     */
    public function seguimientoEstudiantes()
    {
        $estudiantes = Estudiante::with(['user', 'estadia.empresa', 'estadia.profesorSupervisor.user'])
            ->whereHas('estadia')
            ->orderBy('matricula')
            ->paginate(15);
            
        return view('director.seguimiento-estudiantes', compact('estudiantes'));
    }
    
    /**
     * Empresas colaboradoras
     */
    public function empresasColaboradoras()
    {
        $empresas = Empresa::withCount('estadias')
            ->orderBy('razon_social')
            ->paginate(15);
            
        return view('director.empresas-colaboradoras', compact('empresas'));
    }
    
    /**
     * Proyectos disponibles
     */
    public function proyectosDisponibles()
    {
        $proyectos = DB::table('proyectos')
            ->join('empresas', 'proyectos.empresa_id', '=', 'empresas.id')
            ->select('proyectos.*', 'empresas.nombre as empresa_nombre')
            ->where('proyectos.disponible', true)
            ->orderBy('proyectos.created_at', 'desc')
            ->paginate(15);
            
        return view('director.proyectos-disponibles', compact('proyectos'));
    }
    
    /**
     * Documentos pendientes de revisión
     */
    public function documentosPendientes()
    {
        $documentos = Documento::with(['estudiante.user', 'estadia.empresa'])
            ->where('status', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        // Estadísticas para la vista
        $stats = [
            'total_pendientes' => Documento::where('status', 'pendiente')->count(),
            'urgentes' => Documento::where('status', 'pendiente')
                ->where('created_at', '<=', now()->subDays(7))
                ->count(),
            'aprobados_hoy' => Documento::where('status', 'validado')
                ->whereDate('updated_at', today())
                ->count(),
            'tiempo_promedio' => $this->calcularTiempoPromedioRevision()
        ];
            
        $carreras = Carrera::orderBy('nombre')->get();
            
        return view('director.documentos-pendientes', compact('documentos', 'carreras', 'stats'));
    }

    /**
     * Calcular tiempo promedio de revisión de documentos
     */
    private function calcularTiempoPromedioRevision()
    {
        $documentosRevisados = Documento::whereIn('status', ['validado', 'rechazado'])
            ->whereNotNull('updated_at')
            ->get();
            
        if ($documentosRevisados->isEmpty()) {
            return 0;
        }
        
        $tiempoTotal = 0;
        foreach ($documentosRevisados as $documento) {
            $tiempoRevision = $documento->created_at->diffInHours($documento->updated_at);
            $tiempoTotal += $tiempoRevision;
        }
        
        return round($tiempoTotal / $documentosRevisados->count(), 1);
    }

    /**
     * Generar reporte en PDF
     */
    public function generarReportePDF(Request $request)
    {
        $tipoReporte = $request->input('tipo_reporte');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        
        $data = [];
        $titulo = '';
        
        switch ($tipoReporte) {
            case 'estadisticas_generales':
                $titulo = 'Reporte de Estadísticas Generales';
                $data = $this->obtenerEstadisticasGenerales($fechaInicio, $fechaFin);
                break;
                
            case 'estudiantes_por_carrera':
                $titulo = 'Reporte de Estudiantes por Carrera';
                $data = $this->obtenerEstudiantesPorCarrera($fechaInicio, $fechaFin);
                break;
                
            case 'empresas_activas':
                $titulo = 'Reporte de Empresas Activas';
                $data = $this->obtenerEmpresasActivas($fechaInicio, $fechaFin);
                break;
                
            case 'documentos_pendientes':
                $titulo = 'Reporte de Documentos Pendientes';
                $data = $this->obtenerDocumentosPendientes($fechaInicio, $fechaFin);
                break;
                
            default:
                return redirect()->back()->withErrors(['error' => 'Tipo de reporte no válido']);
        }
        
        $pdf = \PDF::loadView('pdf.reporte-director', compact('data', 'titulo', 'fechaInicio', 'fechaFin', 'tipoReporte'));
        $pdf->setPaper('letter', 'portrait');
        
        $fileName = 'Reporte_' . ucfirst(str_replace('_', '_', $tipoReporte)) . '_' . date('Y-m-d') . '.pdf';
        
        return $pdf->download($fileName);
    }
    
    /**
     * Obtener estadísticas generales para reporte
     */
    private function obtenerEstadisticasGenerales($fechaInicio = null, $fechaFin = null)
    {
        $query = Estadia::query();
        
        if ($fechaInicio) {
            $query->whereDate('created_at', '>=', $fechaInicio);
        }
        if ($fechaFin) {
            $query->whereDate('created_at', '<=', $fechaFin);
        }
        
        return [
            'total_estadias' => $query->count(),
            'estadias_activas' => $query->where('status', 'en_proceso')->count(),
            'estadias_completadas' => $query->where('status', 'completada')->count(),
            'total_estudiantes' => Estudiante::count(),
            'total_empresas' => Empresa::count(),
            'documentos_pendientes' => Documento::where('status', 'pendiente')->count(),
            'documentos_aprobados' => Documento::where('status', 'validado')->count(),
        ];
    }
    
    /**
     * Obtener estudiantes por carrera para reporte
     */
    private function obtenerEstudiantesPorCarrera($fechaInicio = null, $fechaFin = null)
    {
        $query = Estudiante::join('carreras', 'estudiantes.carrera_id', '=', 'carreras.id')
            ->join('estadias', 'estudiantes.id', '=', 'estadias.estudiante_id')
            ->selectRaw('carreras.nombre as carrera, COUNT(*) as total')
            ->groupBy('carreras.id', 'carreras.nombre');
            
        if ($fechaInicio) {
            $query->whereDate('estadias.created_at', '>=', $fechaInicio);
        }
        if ($fechaFin) {
            $query->whereDate('estadias.created_at', '<=', $fechaFin);
        }
        
        return $query->orderBy('total', 'desc')->get();
    }
    
    /**
     * Obtener empresas activas para reporte
     */
    private function obtenerEmpresasActivas($fechaInicio = null, $fechaFin = null)
    {
        $query = Empresa::withCount(['estadias' => function($q) use ($fechaInicio, $fechaFin) {
            if ($fechaInicio) {
                $q->whereDate('created_at', '>=', $fechaInicio);
            }
            if ($fechaFin) {
                $q->whereDate('created_at', '<=', $fechaFin);
            }
        }]);
        
        return $query->orderBy('estadias_count', 'desc')->limit(20)->get();
    }
    
    /**
     * Obtener documentos pendientes para reporte
     */
    private function obtenerDocumentosPendientes($fechaInicio = null, $fechaFin = null)
    {
        $query = Documento::with(['estudiante.user', 'estadia.empresa'])
            ->where('status', 'pendiente');
            
        if ($fechaInicio) {
            $query->whereDate('created_at', '>=', $fechaInicio);
        }
        if ($fechaFin) {
            $query->whereDate('created_at', '<=', $fechaFin);
        }
        
        return $query->orderBy('created_at', 'desc')->get();
    }
     
     /**
     * Documentos aprobados
     */
    public function documentosAprobados()
    {
        $documentos = Documento::with(['estudiante.user', 'estadia.empresa'])
            ->where('status', 'aprobado')
            ->orderBy('updated_at', 'desc')
            ->paginate(15);
            
        return view('director.documentos-aprobados', compact('documentos'));
    }
    
    /**
     * Aprobar documento
     */
    public function aprobarDocumento(Request $request, $id)
    {
        $documento = Documento::findOrFail($id);
        
        $documento->update([
            'status' => 'aprobado',
            'comentarios_revision' => $request->comentarios,
            'fecha_revision' => now(),
            'revisado_por' => auth()->id()
        ]);
        
        return redirect()->back()->with('success', 'Documento aprobado exitosamente.');
    }
    
    /**
     * Rechazar documento
     */
    public function rechazarDocumento(Request $request, $id)
    {
        $documento = Documento::findOrFail($id);
        
        $documento->update([
            'status' => 'rechazado',
            'comentarios_revision' => $request->comentarios,
            'fecha_revision' => now(),
            'revisado_por' => auth()->id()
        ]);
        
        return redirect()->back()->with('success', 'Documento rechazado.');
    }
    
    /**
     * Cartas de presentación pendientes de aprobación del director
     */
    public function cartasPendientes()
    {
        $cartas = SolicitudCartaPresentacion::with(['estudiante.user', 'estudiante.carrera', 'revisadaPorProfesor'])
            ->where('estado', 'aprobada_profesor')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('director.cartas-pendientes', compact('cartas'));
    }
    
    /**
     * Aprobar carta de presentación
     */
    public function aprobarCarta(Request $request, $id)
    {
        $carta = SolicitudCartaPresentacion::findOrFail($id);
        
        $carta->update([
            'estado' => 'aprobada_director',
            'comentarios_director' => $request->comentarios,
            'fecha_aprobacion_director' => now(),
            'aprobada_por_director' => auth()->id()
        ]);
        
        return redirect()->back()->with('success', 'Carta de presentación aprobada.');
    }
    
    /**
     * Rechazar carta de presentación
     */
    public function rechazarCarta(Request $request, $id)
    {
        $carta = SolicitudCartaPresentacion::findOrFail($id);
        
        $carta->update([
            'estado' => 'rechazada_director',
            'comentarios_director' => $request->comentarios,
            'fecha_revision_director' => now(),
            'revisada_por_director' => auth()->id()
        ]);
        
        return redirect()->back()->with('success', 'Carta de presentación rechazada.');
    }
    
    /**
     * Generar PDF de la carta de presentación
     */
    public function generarPdfCarta($id)
    {
        $carta = SolicitudCartaPresentacion::with([
            'estudiante.user', 
            'estudiante.carrera',
            'revisadaPorProfesor'
        ])->findOrFail($id);
        
        $data = [
            'carta' => $carta,
            'fecha_generacion' => now()->format('d/m/Y'),
            'director' => auth()->user()
        ];
        
        $pdf = Pdf::loadView('pdfs.carta-presentacion', $data);
        
        return $pdf->stream('carta-presentacion-' . $carta->estudiante->matricula . '.pdf');
    }
    
    /**
     * Firmar y aprobar carta de presentación
     */
    public function firmarCarta(Request $request, $id)
    {
        $request->validate([
            'firma' => 'required|string',
            'comentarios' => 'nullable|string|max:1000'
        ]);
        
        $carta = SolicitudCartaPresentacion::with([
            'estudiante.user', 
            'estudiante.carrera',
            'revisadaPorProfesor'
        ])->findOrFail($id);
        
        try {
            // Procesar la firma (convertir base64 a archivo)
            $firmaData = $request->firma;
            $firmaData = str_replace('data:image/png;base64,', '', $firmaData);
            $firmaData = str_replace(' ', '+', $firmaData);
            $firmaDecoded = base64_decode($firmaData);
            
            // Generar nombre único para la firma
            $firmaFileName = 'firmas/director_' . $id . '_' . time() . '.png';
            Storage::disk('public')->put($firmaFileName, $firmaDecoded);
            
            // Generar PDF con firma
            $data = [
                'carta' => $carta,
                'fecha_generacion' => now()->format('d/m/Y'),
                'director' => auth()->user(),
                'firma_path' => storage_path('app/public/' . $firmaFileName),
                'comentarios_director' => $request->comentarios
            ];
            
            $pdf = Pdf::loadView('pdfs.carta-presentacion-firmada', $data);
            
            // Guardar PDF firmado
            $pdfFileName = 'cartas-firmadas/carta_' . $carta->estudiante->matricula . '_' . time() . '.pdf';
            Storage::disk('public')->put($pdfFileName, $pdf->output());
            
            // Actualizar la carta en la base de datos
            $carta->update([
                'estado' => 'aprobada_director',
                'comentarios_director' => $request->comentarios,
                'fecha_aprobacion_director' => now(),
                'aprobada_por_director' => auth()->id(),
                'archivo_firmado' => $pdfFileName,
                'firma_director' => $firmaFileName,
                'progreso' => 100 // Carta completamente procesada
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Carta firmada y aprobada exitosamente.',
                'pdf_url' => Storage::url($pdfFileName)
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la firma: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Descargar carta firmada
     */
    public function descargarCartaFirmada($id)
    {
        $carta = SolicitudCartaPresentacion::findOrFail($id);
        
        if (!$carta->archivo_firmado || !Storage::disk('public')->exists($carta->archivo_firmado)) {
            abort(404, 'Archivo no encontrado');
        }
        
        return Storage::disk('public')->download(
            $carta->archivo_firmado,
            'carta-presentacion-' . $carta->estudiante->matricula . '.pdf'
        );
    }
    
    /**
     * Reportes y estadísticas
     */
    public function reportes()
    {
        // Estadísticas por mes
        $estadisticasMensuales = Estadia::selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();
            
        // Estadísticas por carrera
        $estadisticasCarrera = Estudiante::join('carreras', 'estudiantes.carrera_id', '=', 'carreras.id')
            ->join('estadias', 'estudiantes.id', '=', 'estadias.estudiante_id')
            ->selectRaw('carreras.nombre, COUNT(*) as total')
            ->groupBy('carreras.id', 'carreras.nombre')
            ->orderBy('total', 'desc')
            ->get();
            
        // Empresas más activas
        $empresasActivas = Empresa::withCount('estadias')
            ->orderBy('estadias_count', 'desc')
            ->limit(10)
            ->get();
            
        return view('director.reportes', compact(
            'estadisticasMensuales',
            'estadisticasCarrera', 
            'empresasActivas'
        ));
    }
    
    /**
     * Crear nueva asignación
     */
    public function crearAsignacion(Request $request)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'profesor_id' => 'required|exists:profesores,id',
            'empresa_id' => 'required|exists:empresas,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio'
        ]);
        
        // Verificar que el estudiante no tenga una estadía activa
        $estadiaExistente = Estadia::where('estudiante_id', $request->estudiante_id)
            ->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])
            ->first();
            
        if ($estadiaExistente) {
            return redirect()->back()->with('error', 'El estudiante ya tiene una estadía activa.');
        }
        
        Estadia::create([
            'estudiante_id' => $request->estudiante_id,
            'tutor_id' => $request->profesor_id,
            'empresa_id' => $request->empresa_id,
            'periodo' => '2024-2025',
            'fecha_solicitud' => now(),
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'status' => 'en_proceso',
            'modalidad' => 'presencial',
            'horas_semanales' => 40
        ]);
        
        return redirect()->back()->with('success', 'Asignación creada exitosamente.');
    }

    /**
     * Calcular el progreso promedio de las estadías activas
     */
    private function calcularProgresoPromedio()
    {
        $estadiasActivas = Estadia::whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])
            ->whereNotNull('fecha_inicio')
            ->whereNotNull('fecha_fin')
            ->get();

        if ($estadiasActivas->isEmpty()) {
            return 0;
        }

        $totalProgreso = 0;
        foreach ($estadiasActivas as $estadia) {
            // Calcular progreso basado en fechas si no existe el método porcentaje_progreso
            if (method_exists($estadia, 'porcentaje_progreso')) {
                $totalProgreso += $estadia->porcentaje_progreso;
            } else {
                $fechaInicio = $estadia->fecha_inicio;
                $fechaFin = $estadia->fecha_fin;
                $fechaActual = now();
                
                if ($fechaInicio && $fechaFin) {
                    $totalDias = $fechaInicio->diffInDays($fechaFin);
                    $diasTranscurridos = $fechaInicio->diffInDays($fechaActual);
                    $progreso = $totalDias > 0 ? min(100, ($diasTranscurridos / $totalDias) * 100) : 0;
                    $totalProgreso += $progreso;
                }
            }
        }

        return round($totalProgreso / $estadiasActivas->count(), 1);
    }
}