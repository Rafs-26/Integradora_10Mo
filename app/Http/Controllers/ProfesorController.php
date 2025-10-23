<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Estudiante;
use App\Models\Estadia;
use App\Models\Documento;
use App\Models\Cita;
use App\Models\User;
use App\Models\SolicitudCartaPresentacion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProfesorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Profesor');
    }

    /**
     * Mostrar el dashboard del profesor
     */
    public function dashboard()
    {
        $user = Auth::user();
        $profesor = $user->profesor;
        
        if (!$profesor) {
            return redirect()->route('login')->with('error', 'No se encontró información del profesor.');
        }

        // Obtener estudiantes supervisados
        $estudiantesSupervisados = $profesor->estudiantesSupervisados()->with(['user', 'carrera', 'estadias.empresa'])->get();
        
        // Estadísticas del dashboard
        $stats = [
            'estudiantes_supervisados' => $estudiantesSupervisados->count(),
            'documentos_pendientes' => Documento::whereHas('estadia.profesorSupervisor', function($query) use ($profesor) {
                $query->where('id', $profesor->id);
            })->where('status', 'pendiente')->count(),
            'evaluaciones_completadas' => Documento::whereHas('estadia.profesorSupervisor', function($query) use ($profesor) {
                $query->where('id', $profesor->id);
            })->where('tipo_documento', 'evaluacion')
              ->where('status', 'validado')
              ->whereMonth('updated_at', now()->month)
              ->count(),
            'citas_programadas' => Cita::where('tutor_id', $profesor->id)
                                      ->where('fecha', '>=', now())
                                      ->where('status', 'programada')
                                      ->count()
        ];

        // Documentos pendientes recientes
        $documentosPendientes = Documento::with(['estudiante.user', 'estadia.empresa'])
            ->whereHas('estadia.profesorSupervisor', function($query) use ($profesor) {
                $query->where('id', $profesor->id);
            })
            ->where('status', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Próximas citas
        $proximasCitas = Cita::with(['estudiante.user'])
            ->where('tutor_id', $profesor->id)
            ->where('fecha', '>=', now())
            ->where('status', 'programada')
            ->orderBy('fecha', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->limit(5)
            ->get();

        return view('profesor.dashboard', compact(
            'user', 
            'profesor', 
            'estudiantesSupervisados', 
            'stats', 
            'documentosPendientes', 
            'proximasCitas'
        ));
    }

    /**
     * Mostrar lista de estudiantes supervisados
     */
    public function misEstudiantes()
    {
        $profesor = Auth::user()->profesor;
        
        // Obtener estudiantes supervisados por estadías
        $estudiantesPorEstadias = $profesor->estudiantesSupervisados()
            ->with(['user', 'carrera', 'estadias' => function($query) {
                $query->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos']);
            }, 'estadias.empresa'])
            ->get();
        
        // Obtener estudiantes asignados por AsignacionTutor
        $estudiantesPorAsignaciones = Estudiante::with(['user', 'carrera', 'estadias' => function($query) {
                $query->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos']);
            }, 'estadias.empresa'])
            ->whereHas('asignacionesTutor', function($query) use ($profesor) {
                $query->where('tutor_id', $profesor->id)
                      ->where('status', 'activa');
            })
            ->get();
            
        // Combinar y eliminar duplicados
        $estudiantes = $estudiantesPorEstadias->merge($estudiantesPorAsignaciones)->unique('id')
            ->map(function($estudiante) {
                // Agregar información de la estadía activa al estudiante
                $estadiaActiva = $estudiante->estadias->first();
                if ($estadiaActiva) {
                    $estudiante->empresa = $estadiaActiva->empresa;
                    $estudiante->fecha_inicio_estadia = $estadiaActiva->fecha_inicio;
                    $estudiante->fecha_fin_estadia = $estadiaActiva->fecha_fin;
                    $estudiante->estatus_estadia = $estadiaActiva->status;
                    $estudiante->modalidad_estadia = $estadiaActiva->modalidad ?? 'Presencial';
                    
                    // Calcular progreso basado en documentos completados
                    $totalDocumentos = 5; // Número esperado de documentos
                    $documentosCompletados = $estadiaActiva->documentos()->where('status', 'validado')->count();
                    $estudiante->progreso_estadia = $totalDocumentos > 0 ? round(($documentosCompletados / $totalDocumentos) * 100) : 0;
                } else {
                    $estudiante->empresa = null;
                    $estudiante->estatus_estadia = 'sin_asignar';
                    $estudiante->progreso_estadia = 0;
                }
                
                // Agregar propiedades de usuario
                $estudiante->name = $estudiante->user->name;
                $estudiante->email = $estudiante->user->email;
                
                return $estudiante;
            });

        return view('profesor.mis-estudiantes', compact('estudiantes'));
    }

    /**
     * Mostrar seguimiento de estadías
     */
    public function seguimiento()
    {
        $profesor = Auth::user()->profesor;
        
        // Obtener estudiantes supervisados por estadías
        $estudiantesPorEstadias = $profesor->estudiantesSupervisados()
            ->with([
                'user', 
                'carrera',
                'estadias' => function($query) {
                    $query->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos'])
                          ->with(['empresa', 'documentos' => function($docQuery) {
                              $docQuery->where('tipo_documento', 'evaluacion')
                                       ->where('status', 'validado')
                                       ->orderBy('created_at', 'desc')
                                       ->limit(3);
                          }]);
                }
            ])
            ->get();
            
        // Obtener estudiantes asignados por AsignacionTutor
        $estudiantesPorAsignaciones = Estudiante::with([
                'user', 
                'carrera',
                'estadias' => function($query) {
                    $query->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos'])
                          ->with(['empresa', 'documentos' => function($docQuery) {
                              $docQuery->where('tipo_documento', 'evaluacion')
                                       ->where('status', 'validado')
                                       ->orderBy('created_at', 'desc')
                                       ->limit(3);
                          }]);
                }
            ])
            ->whereHas('asignacionesTutor', function($query) use ($profesor) {
                $query->where('tutor_id', $profesor->id)
                      ->where('status', 'activa');
            })
            ->get();
            
        // Combinar y eliminar duplicados
        $estudiantes = $estudiantesPorEstadias->merge($estudiantesPorAsignaciones)->unique('id')
            ->map(function($estudiante) {
                // Agregar información de la estadía activa al estudiante
                $estadiaActiva = $estudiante->estadias->first();
                if ($estadiaActiva) {
                    $estudiante->empresa = $estadiaActiva->empresa;
                    $estudiante->fecha_inicio_estadia = $estadiaActiva->fecha_inicio;
                    $estudiante->fecha_fin_estadia = $estadiaActiva->fecha_fin;
                    $estudiante->estatus_estadia = $estadiaActiva->status;
                    $estudiante->modalidad_estadia = $estadiaActiva->modalidad ?? 'presencial';
                    $estudiante->evaluaciones = $estadiaActiva->documentos;
                    
                    // Calcular progreso basado en documentos completados
                    $totalDocumentos = 5; // Número esperado de documentos
                    $documentosCompletados = $estadiaActiva->documentos()->where('status', 'validado')->count();
                    $estudiante->progreso_estadia = $totalDocumentos > 0 ? round(($documentosCompletados / $totalDocumentos) * 100) : 0;
                } else {
                    $estudiante->empresa = null;
                    $estudiante->fecha_inicio_estadia = null;
                    $estudiante->fecha_fin_estadia = null;
                    $estudiante->estatus_estadia = 'sin_asignar';
                    $estudiante->modalidad_estadia = null;
                    $estudiante->evaluaciones = collect();
                    $estudiante->progreso_estadia = 0;
                }
                
                // Agregar propiedades de usuario
                $estudiante->name = $estudiante->user->name;
                $estudiante->email = $estudiante->user->email;
                
                return $estudiante;
            });

        return view('profesor.seguimiento', compact('estudiantes'));
    }

    /**
     * Mostrar solicitudes de cartas de presentación pendientes de aprobación
     */
    public function solicitudesCartas()
    {
        $profesor = Auth::user()->profesor;
        
        // Obtener solicitudes pendientes de estudiantes supervisados por el profesor
        $solicitudes = SolicitudCartaPresentacion::with([
            'estudiante.user',
            'estadia.empresa',
            'estadia.profesorSupervisor'
        ])
        ->whereHas('estadia', function($query) use ($profesor) {
            $query->where('tutor_id', $profesor->id);
        })
        ->where('estado', 'pendiente')
        ->orderBy('fecha_solicitud', 'desc')
        ->get();

        return view('profesor.solicitudes-cartas', compact('solicitudes'));
    }

    /**
     * Aprobar una solicitud de carta de presentación
     */
    public function aprobarSolicitudCarta(Request $request, $id)
    {
        $profesor = Auth::user()->profesor;
        
        $solicitud = SolicitudCartaPresentacion::with('estadia')
            ->whereHas('estadia', function($query) use ($profesor) {
                $query->where('tutor_id', $profesor->id);
            })
            ->findOrFail($id);

        if ($solicitud->estado !== 'pendiente') {
            return redirect()->back()->with('error', 'Esta solicitud ya ha sido procesada.');
        }

        $solicitud->update([
            'estado' => 'aprobada_profesor',
            'fecha_revision_profesor' => now(),
            'fecha_aprobacion_profesor' => now(),
            'revisada_por_profesor' => Auth::user()->id,
            'comentarios_profesor' => $request->input('comentarios')
        ]);

        return redirect()->back()->with('success', 'Solicitud aprobada correctamente. Ahora será enviada al director para su aprobación final.');
    }

    /**
     * Rechazar una solicitud de carta de presentación
     */
    public function rechazarSolicitudCarta(Request $request, $id)
    {
        $profesor = Auth::user()->profesor;
        
        $solicitud = SolicitudCartaPresentacion::with('estadia')
            ->whereHas('estadia', function($query) use ($profesor) {
                $query->where('tutor_id', $profesor->id);
            })
            ->findOrFail($id);

        if ($solicitud->estado !== 'pendiente') {
            return redirect()->back()->with('error', 'Esta solicitud ya ha sido procesada.');
        }

        $request->validate([
            'comentarios' => 'required|string|max:500'
        ]);

        $solicitud->update([
            'estado' => 'rechazada_profesor',
            'fecha_revision_profesor' => now(),
            'revisada_por_profesor' => Auth::user()->id,
            'comentarios_profesor' => $request->input('comentarios')
        ]);

        return redirect()->back()->with('success', 'Solicitud rechazada. El estudiante ha sido notificado.');
    }

    /**
     * Mostrar evaluaciones
     */
    public function evaluaciones()
    {
        $profesor = Auth::user()->profesor;
        
        // Obtener evaluaciones de estudiantes asignados al profesor
        $evaluaciones = Documento::with(['estudiante.user', 'estadia.empresa'])
            ->where('tipo_documento', 'evaluacion')
            ->where(function($query) use ($profesor) {
                // Buscar por estadías donde el profesor es tutor
                $query->whereHas('estadia', function($subQuery) use ($profesor) {
                    $subQuery->where('tutor_id', $profesor->id);
                })
                // O buscar por estudiantes que tienen asignación de tutor activa con este profesor
                ->orWhereHas('estudiante.asignacionesTutor', function($subQuery) use ($profesor) {
                    $subQuery->where('tutor_id', $profesor->id)
                             ->where('status', 'activa');
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Obtener estudiantes supervisados (tanto por estadías como por asignaciones)
        $estudiantesPorEstadias = $profesor->estudiantesSupervisados()->with('user')->get();
        
        $estudiantesPorAsignaciones = Estudiante::with('user')
            ->whereHas('asignacionesTutor', function($query) use ($profesor) {
                $query->where('tutor_id', $profesor->id)
                      ->where('status', 'activa');
            })
            ->get();
            
        // Combinar y eliminar duplicados
        $estudiantes = $estudiantesPorEstadias->merge($estudiantesPorAsignaciones)->unique('id');

        return view('profesor.evaluaciones', compact('evaluaciones', 'estudiantes'));
    }

    /**
     * Crear nueva evaluación
     */
    public function crearEvaluacion(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'estudiante_id' => 'required|exists:estudiantes,id',
                'tipo_evaluacion' => 'required|string',
                'calificacion' => 'required|numeric|min:0|max:10',
                'comentarios' => 'required|string',
                'fecha_evaluacion' => 'required|date'
            ]);

            $profesor = Auth::user()->profesor;
            $estudiante = Estudiante::findOrFail($request->estudiante_id);
            $estadia = $estudiante->estadias()->where('status', 'en_proceso')->first();

            if (!$estadia) {
                return back()->with('error', 'El estudiante no tiene una estadía activa.');
            }

            Documento::create([
                'estadia_id' => $estadia->id,
                'estudiante_id' => $estudiante->id,
                'tipo_documento' => 'evaluacion',
                'nombre_archivo' => 'Evaluación ' . $request->tipo_evaluacion,
                'descripcion' => $request->comentarios,
                'status' => 'validado',
                'calificacion' => $request->calificacion,
                'fecha_evaluacion' => $request->fecha_evaluacion,
                'revisado_por' => $profesor->id,
                'fecha_revision' => now()
            ]);

            return redirect()->route('teacher.evaluaciones')->with('success', 'Evaluación creada exitosamente.');
        }

        $profesor = Auth::user()->profesor;
        $estudiantes = $profesor->estudiantesSupervisados()->with('user')->get();
        
        return view('profesor.crear-evaluacion', compact('estudiantes'));
    }

    /**
     * Mostrar documentos por revisar
     */
    public function documentosPorRevisar()
    {
        $profesor = Auth::user()->profesor;
        $documentos = Documento::with(['estudiante.user', 'estadia.empresa'])
            ->whereHas('estadia', function($query) use ($profesor) {
                $query->where('tutor_id', $profesor->id);
            })
            ->where('status', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $estudiantes = $profesor->estudiantesSupervisados()->with('user')->get();

        return view('profesor.documentos-por-revisar', compact('documentos', 'estudiantes'));
    }

    /**
     * Revisar documento
     */
    public function revisarDocumento(Request $request, $id)
    {
        $request->validate([
            'accion' => 'required|in:aprobar,rechazar',
            'comentarios' => 'required_if:accion,rechazar|string'
        ]);

        $documento = Documento::findOrFail($id);
        $profesor = Auth::user()->profesor;

        // Verificar que el profesor puede revisar este documento
        if ($documento->estadia->tutor_id !== $profesor->id) {
            return back()->with('error', 'No tienes permisos para revisar este documento.');
        }

        $documento->update([
            'status' => $request->accion === 'aprobar' ? 'validado' : 'rechazado',
            'comentarios_revision' => $request->comentarios,
            'revisado_por' => $profesor->id,
            'fecha_revision' => now()
        ]);

        $mensaje = $request->accion === 'aprobar' ? 'Documento aprobado exitosamente.' : 'Documento rechazado.';
        return back()->with('success', $mensaje);
    }

    /**
     * Mostrar documentos revisados
     */
    public function documentosRevisados()
    {
        $profesor = Auth::user()->profesor;
        $documentos = Documento::with(['estudiante.user', 'estadia.empresa'])
            ->whereHas('estadia', function($query) use ($profesor) {
                $query->where('tutor_id', $profesor->id);
            })
            ->whereIn('status', ['validado', 'rechazado'])
            ->orderBy('fecha_revision', 'desc')
            ->paginate(10);

        $estudiantes = $profesor->estudiantesSupervisados()->with('user')->get();

        return view('profesor.documentos-revisados', compact('documentos', 'estudiantes'));
    }

    /**
     * Mostrar formatos disponibles
     */
    public function formatos()
    {
        // Lista de formatos disponibles
        $formatos = [
            [
                'nombre' => 'Formato de Evaluación Intermedia',
                'descripcion' => 'Formato para evaluar el progreso del estudiante a mitad de la estadía',
                'archivo' => 'formatos/evaluacion_intermedia.pdf',
                'tipo' => 'evaluacion'
            ],
            [
                'nombre' => 'Formato de Evaluación Final',
                'descripcion' => 'Formato para la evaluación final del estudiante',
                'archivo' => 'formatos/evaluacion_final.pdf',
                'tipo' => 'evaluacion'
            ],
            [
                'nombre' => 'Reporte de Seguimiento',
                'descripcion' => 'Formato para reportes de seguimiento semanal',
                'archivo' => 'formatos/reporte_seguimiento.pdf',
                'tipo' => 'reporte'
            ],
            [
                'nombre' => 'Carta de Recomendación',
                'descripcion' => 'Formato para cartas de recomendación',
                'archivo' => 'formatos/carta_recomendacion.pdf',
                'tipo' => 'carta'
            ]
        ];

        return view('profesor.formatos', compact('formatos'));
    }

    /**
     * Descargar formato
     */
    public function descargarFormato($archivo)
    {
        $rutaArchivo = storage_path('app/public/' . $archivo);
        
        if (!file_exists($rutaArchivo)) {
            return back()->with('error', 'El archivo no existe.');
        }

        return response()->download($rutaArchivo);
    }

    /**
     * Mostrar reportes y estadísticas
     */
    public function reportes()
    {
        $profesor = Auth::user()->profesor;
        
        // Estadísticas generales
        $estadisticas = [
            'total_estudiantes' => $profesor->estudiantesSupervisados()->count(),
            'estadias_activas' => $profesor->estadiasSupervisadas()->whereIn('status', ['en_proceso'])->count(),
            'estadias_completadas' => $profesor->estadiasSupervisadas()->where('status', 'completada')->count(),
            'documentos_revisados_mes' => Documento::whereHas('estadia', function($query) use ($profesor) {
                $query->where('tutor_id', $profesor->id);
            })->whereMonth('fecha_revision', now()->month)->count(),
            'promedio_calificaciones' => Documento::whereHas('estadia', function($query) use ($profesor) {
                $query->where('tutor_id', $profesor->id);
            })->where('tipo_documento', 'evaluacion')
              ->where('status', 'validado')
              ->avg('calificacion') ?? 0
        ];

        return view('profesor.reportes', compact('estadisticas'));
    }

    /**
     * Mostrar mensajes
     */
    public function mensajes()
    {
        // Por ahora mostrar vista básica, se puede expandir con sistema de mensajería
        $profesor = Auth::user()->profesor;
        $estudiantes = $profesor->estudiantesSupervisados()->with('user')->get();
        
        return view('profesor.mensajes', compact('estudiantes'));
    }

    /**
     * Mostrar calendario de citas
     */
    public function programarCitas()
    {
        $profesor = Auth::user()->profesor;
        $citas = Cita::with(['estudiante.user'])
            ->where('tutor_id', $profesor->id)
            ->where('fecha', '>=', now()->startOfMonth())
            ->where('fecha', '<=', now()->endOfMonth())
            ->orderBy('fecha', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->get();

        $estudiantes = $profesor->estudiantesSupervisados()->with('user')->get();

        return view('profesor.programar-citas', compact('citas', 'estudiantes'));
    }

    /**
     * Crear nueva cita
     */
    public function crearCita(Request $request)
    {
        $request->validate([
            'estudiante_id' => 'required|exists:estudiantes,id',
            'fecha' => 'required|date|after:today',
            'hora_inicio' => 'required',
            'duracion' => 'required|integer|min:15|max:180',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'modalidad' => 'required|in:presencial,virtual'
        ]);

        $profesor = Auth::user()->profesor;
        
        // Verificar que el estudiante esté bajo supervisión del profesor
        $estudiante = $profesor->estudiantesSupervisados()->find($request->estudiante_id);
        if (!$estudiante) {
            return back()->with('error', 'El estudiante seleccionado no está bajo tu supervisión.');
        }

        // Calcular hora de fin
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora_inicio);
        $horaFin = $horaInicio->copy()->addMinutes($request->duracion);

        Cita::create([
            'estudiante_id' => $request->estudiante_id,
            'tutor_id' => $profesor->id,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $horaFin->format('H:i'),
            'modalidad' => $request->modalidad,
            'status' => 'programada',
            'creado_por' => auth()->id()
        ]);

        return back()->with('success', 'Cita programada exitosamente.');
    }

    /**
     * Completar una cita
     */
    public function completarCita(Request $request, $id)
    {
        $request->validate([
            'observaciones_tutor' => 'nullable|string|max:1000'
        ]);

        $cita = Cita::findOrFail($id);
        $profesor = Auth::user()->profesor;

        // Verificar que el profesor puede completar esta cita
        if ($cita->tutor_id !== $profesor->id) {
            return back()->with('error', 'No tienes permisos para completar esta cita.');
        }

        $cita->update([
            'status' => 'completada',
            'observaciones_tutor' => $request->observaciones_tutor
        ]);

        return back()->with('success', 'Cita completada exitosamente.');
    }

    /**
     * Editar una cita
     */
    public function editarCita(Request $request, $id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'duracion' => 'required|integer|min:15|max:180',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'modalidad' => 'required|in:presencial,virtual'
        ]);

        $cita = Cita::findOrFail($id);
        $profesor = Auth::user()->profesor;

        // Verificar que el profesor puede editar esta cita
        if ($cita->tutor_id !== $profesor->id) {
            return back()->with('error', 'No tienes permisos para editar esta cita.');
        }

        // Solo permitir editar citas programadas
        if ($cita->status !== 'programada') {
            return back()->with('error', 'Solo se pueden editar citas programadas.');
        }

        // Calcular hora de fin
        $horaInicio = Carbon::createFromFormat('H:i', $request->hora_inicio);
        $horaFin = $horaInicio->copy()->addMinutes($request->duracion);

        $cita->update([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'fecha' => $request->fecha,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $horaFin->format('H:i'),
            'modalidad' => $request->modalidad
        ]);

        return back()->with('success', 'Cita actualizada exitosamente.');
    }

    /**
     * Cancelar una cita
     */
    public function cancelarCita($id)
    {
        $cita = Cita::findOrFail($id);
        $profesor = Auth::user()->profesor;

        // Verificar que el profesor puede cancelar esta cita
        if ($cita->tutor_id !== $profesor->id) {
            return back()->with('error', 'No tienes permisos para cancelar esta cita.');
        }

        // Solo permitir cancelar citas programadas
        if ($cita->status !== 'programada') {
            return back()->with('error', 'Solo se pueden cancelar citas programadas.');
        }

        $cita->update([
            'status' => 'cancelada',
            'fecha_cancelacion' => now()
        ]);

        return back()->with('success', 'Cita cancelada exitosamente.');
    }

    /**
     * Mostrar perfil del profesor
     */
    public function perfil()
    {
        $profesor = Auth::user()->profesor;
        return view('profesor.perfil', compact('profesor'));
    }

    /**
     * Actualizar perfil del profesor
     */
    public function actualizarPerfil(Request $request)
    {
        $request->validate([
            'telefono' => 'nullable|string|max:20',
            'extension' => 'nullable|string|max:10',
            'especialidad' => 'nullable|string|max:255',
            'grado_academico' => 'nullable|string|max:100'
        ]);

        $profesor = Auth::user()->profesor;
        $profesor->update($request->only(['telefono', 'extension', 'especialidad', 'grado_academico']));

        return back()->with('success', 'Perfil actualizado exitosamente.');
    }
}