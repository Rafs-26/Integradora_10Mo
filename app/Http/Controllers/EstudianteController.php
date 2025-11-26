<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Estadia;
use App\Models\Documento;
use App\Models\Cita;
use App\Models\Empresa;
use App\Models\Profesor;
use App\Models\Estudiante;
use App\Models\Carrera;
use App\Models\User;
use App\Models\LogActividad;
use Carbon\Carbon;
use PDF;

class EstudianteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Estudiante');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;
        
        // Obtener estadía actual del estudiante
        $estadia = null;
        if ($estudiante) {
            $estadia = Estadia::where('estudiante_id', $estudiante->id)
                            ->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])
                            ->first();
        }
        
        // Estadísticas del dashboard
        $stats = [
            'documentos_pendientes' => $estudiante ? \App\Models\Documento::whereHas('estadia', function($query) use ($estudiante) {
                $query->where('estudiante_id', $estudiante->id);
            })->where('documentos.status', 'pendiente')->count() : 0,
            'citas_programadas' => $estudiante ? $estudiante->citas()
                                                     ->where('fecha', '>=', now())
                                                     ->count() : 0,
            'reportes_entregados' => $estudiante ? \App\Models\Documento::whereHas('estadia', function($query) use ($estudiante) {
                $query->where('estudiante_id', $estudiante->id);
            })->where('tipo_documento', 'reporte')
              ->where('documentos.status', 'validado')->count() : 0,
            'progreso_estadia' => $estadia ? $this->calcularProgresoEstadia($estadia) : 0
        ];
        
        return view('estudiante.dashboard', compact('user', 'estudiante', 'estadia', 'stats'));
    }

    public function miEstadia()
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;
        
        $estadiaActual = null;
        if ($estudiante) {
            $estadiaActual = $estudiante->estadias()->with(['empresa', 'asesorAcademico.user', 'profesorSupervisor.user'])->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])->first();
        }
        
        $progreso = $estadiaActual ? $this->calcularProgresoEstadia($estadiaActual) : 0;
        
        // Próximas citas
        $proximasCitas = [];
        if ($estudiante) {
            $proximasCitas = $estudiante->citas()
                ->with('tutor.user')
                ->where('fecha', '>=', now()->toDateString())
                ->where('status', 'programada')
                ->orderBy('fecha', 'asc')
                ->orderBy('hora_inicio', 'asc')
                ->take(3)
                ->get();
        }
        
        // Documentos pendientes
        $documentosPendientes = [];
        if ($estadiaActual) {
            // Documentos requeridos que aún no se han subido o están pendientes
            $tiposRequeridos = ['propuesta', 'reporte_parcial', 'reporte_final', 'carta_aceptacion'];
            foreach ($tiposRequeridos as $tipo) {
                $documento = \App\Models\Documento::where('estadia_id', $estadiaActual->id)
                    ->where('tipo_documento', $tipo)
                    ->first();
                
                if (!$documento || in_array($documento->status, ['pendiente', 'rechazado'])) {
                    $documentosPendientes[] = [
                        'tipo' => $tipo,
                        'nombre' => $this->getNombreDocumento($tipo),
                        'estado' => $documento ? $documento->status : 'no_subido',
                        'fecha_limite' => $this->getFechaLimiteDocumento($tipo, $estadiaActual)
                    ];
                }
            }
        }
        
        // Tareas pendientes
        $tareasPendientes = [];
        if ($estudiante) {
            // Verificar si tiene citas sin confirmar
            $citasSinConfirmar = $estudiante->citas()->where('status', 'programada')->count();
            if ($citasSinConfirmar > 0) {
                $tareasPendientes[] = [
                    'tipo' => 'citas',
                    'descripcion' => "Tienes {$citasSinConfirmar} cita(s) programada(s)",
                    'prioridad' => 'media',
                    'enlace' => route('student.citas')
                ];
            }
            
            // Verificar documentos vencidos
            foreach ($documentosPendientes as $doc) {
                if ($doc['fecha_limite'] && \Carbon\Carbon::parse($doc['fecha_limite'])->isPast()) {
                    $tareasPendientes[] = [
                        'tipo' => 'documento_vencido',
                        'descripcion' => "Documento vencido: {$doc['nombre']}",
                        'prioridad' => 'alta',
                        'enlace' => route('student.documentos')
                    ];
                }
            }
            
            // Verificar si necesita actualizar perfil
            if (!$estudiante->telefono || !$estudiante->direccion) {
                $tareasPendientes[] = [
                    'tipo' => 'perfil',
                    'descripcion' => 'Completa tu información de perfil',
                    'prioridad' => 'baja',
                    'enlace' => route('student.perfil')
                ];
            }
        }
        
        // Actividades recientes relacionadas con la estadía
        $actividadesRecientes = [];
        if ($estudiante) {
            // Documentos recientes
            $documentosRecientes = \App\Models\Documento::whereHas('estadia', function($query) use ($estudiante) {
                $query->where('estudiante_id', $estudiante->id);
            })->latest()->take(3)->get();
            foreach ($documentosRecientes as $doc) {
                $actividadesRecientes[] = [
                    'tipo' => 'documento',
                    'descripcion' => "Documento: {$doc->nombre_archivo}",
                    'fecha' => $doc->created_at,
                    'estado' => $doc->status
                ];
            }
            
            // Citas recientes (completadas o canceladas)
            $citasRecientes = $estudiante->citas()
                ->whereIn('status', ['completada', 'cancelada'])
                ->latest()
                ->take(2)
                ->get();
            foreach ($citasRecientes as $cita) {
                $actividadesRecientes[] = [
                    'tipo' => 'cita',
                    'descripcion' => "Cita {$cita->status}: {$cita->titulo}",
                    'fecha' => $cita->updated_at,
                    'estado' => $cita->status
                ];
            }
        }
        
        // Ordenar actividades por fecha
        usort($actividadesRecientes, function($a, $b) {
            return $b['fecha']->timestamp - $a['fecha']->timestamp;
        });
        
        $actividadesRecientes = array_slice($actividadesRecientes, 0, 5);
        
        return view('estudiante.mi-estadia', compact('user', 'estudiante', 'progreso', 'actividadesRecientes', 'proximasCitas', 'documentosPendientes', 'tareasPendientes'))->with('estadia', $estadiaActual);
    }

    public function documentos()
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;
        
        $documentos = collect();
        if ($estudiante) {
            $documentos = \App\Models\Documento::whereHas('estadia', function($query) use ($estudiante) {
                $query->where('estudiante_id', $estudiante->id);
            })->orderBy('created_at', 'desc')->get();
        }
        
        return view('estudiante.documentos', compact('user', 'estudiante', 'documentos'));
    }

    public function subirDocumento(Request $request)
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;
        
        if (!$estudiante) {
            return redirect()->back()->with('error', 'No se encontró información del estudiante.');
        }
        
        // Obtener la estadía actual del estudiante
        $estadia = Estadia::where('estudiante_id', $estudiante->id)
                         ->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])
                         ->first();
        
        if (!$estadia) {
            return redirect()->back()->with('error', 'No se encontró una estadía activa para subir documentos.');
        }
        
        // Obtener configuración de documentos
        $config = config('documentos');
        
        $request->validate([
            'tipo_documento' => 'required|string|in:' . implode(',', array_keys($config['tipos_documento'])),
            'archivo' => 'required|file|mimes:' . implode(',', $config['validation']['allowed_mimes']) . '|max:' . $config['validation']['max_size'],
            'descripcion' => 'nullable|string|max:500'
        ]);
        
        try {
            $archivo = $request->file('archivo');
            
            // Crear estructura de carpetas organizada por estudiante y tipo
            $carpetaEstudiante = $config['storage']['path'] . '/' . $estudiante->id;
            $carpetaTipo = $carpetaEstudiante . '/' . $request->tipo_documento;
            
            // Generar nombre único para el archivo
            $extension = $archivo->getClientOriginalExtension();
            $nombreUnico = time() . '_' . uniqid() . '.' . $extension;
            $rutaCompleta = $carpetaTipo . '/' . $nombreUnico;
            
            // Calcular hash del archivo antes de guardarlo
            $contenidoArchivo = file_get_contents($archivo->getRealPath());
            $hashArchivo = hash($config['security']['hash_algorithm'], $contenidoArchivo);
            
            // Verificar duplicados si está habilitado
            if ($config['security']['check_duplicates']) {
                $documentoExistente = \App\Models\Documento::where('hash_archivo', $hashArchivo)
                    ->whereHas('estadia', function($query) use ($estudiante) {
                        $query->where('estudiante_id', $estudiante->id);
                    })->first();
                    
                if ($documentoExistente) {
                    return redirect()->back()->with('warning', 'Este archivo ya ha sido subido anteriormente.');
                }
            }
            
            // Guardar el archivo
            $rutaArchivo = $archivo->storeAs($carpetaTipo, $nombreUnico, $config['storage']['disk']);
            
            // Crear registro en base de datos
            $documento = Documento::create([
                'estadia_id' => $estadia->id,
                'tipo_documento' => $request->tipo_documento,
                'nombre_archivo' => $archivo->getClientOriginalName(),
                'ruta_archivo' => $rutaArchivo,
                'tipo_mime' => $archivo->getMimeType(),
                'tamaño_archivo' => $archivo->getSize(),
                'hash_archivo' => hash_file('sha256', $archivo->getPathname()),
                'status' => 'pendiente',
                'subido_por' => auth()->id(),
                'observaciones' => $request->descripcion
            ]);
            
            // Registrar actividad
            \App\Models\LogActividad::registrarActividad(
                'subida_documento',
                "Subida del documento: {$documento->nombre_archivo} (Tipo: {$request->tipo_documento})",
                [
                    'tabla_afectada' => 'documentos',
                    'registro_id' => $documento->id
                ]
            );
            
            return redirect()->back()->with('success', 'Documento subido exitosamente. Se ha guardado de forma segura en el servidor.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al subir el documento: ' . $e->getMessage());
        }
    }

    public function descargarDocumento($id)
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;
        
        if (!$estudiante) {
            abort(403, 'No autorizado');
        }
        
        $documento = \App\Models\Documento::whereHas('estadia', function($query) use ($estudiante) {
            $query->where('estudiante_id', $estudiante->id);
        })->findOrFail($id);
        
        // Verificar que el archivo existe
        $rutaCompleta = storage_path('app/public/' . $documento->ruta_archivo);
        
        if (!file_exists($rutaCompleta)) {
            return redirect()->back()->with('error', 'El archivo no existe en el servidor.');
        }
        
        // Registrar la descarga
        \App\Models\LogActividad::registrarActividad(
            'descarga_documento',
            "Descarga del documento: {$documento->nombre_archivo}",
            [
                'tabla_afectada' => 'documentos',
                'registro_id' => $documento->id
            ]
        );
        
        return response()->download($rutaCompleta, $documento->nombre_archivo, [
            'Content-Type' => $documento->tipo_mime,
        ]);
    }

    public function citas()
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;
        
        $citas = collect();
        $tutorAsignado = null;
        
        if ($estudiante) {
            $citas = $estudiante->citas()->with('tutor.user')->orderBy('fecha', 'desc')->get();
            // Obtener el tutor asignado al estudiante
            $tutorAsignado = $estudiante->tutorAsignado;
        }
        
        return view('estudiante.citas', compact('user', 'estudiante', 'citas', 'tutorAsignado'));
    }

    public function agendarCita(Request $request)
    {
        $request->validate([
            'tipo_cita' => 'required|string',
            'fecha_solicitada' => 'required|date|after:today',
            'hora_solicitada' => 'required',
            'motivo' => 'required|string|max:500',
            'modalidad' => 'required|in:presencial,virtual'
        ]);
        
        $user = Auth::user();
        $estudiante = $user->estudiante;
        
        if (!$estudiante) {
            return redirect()->back()->with('error', 'No se encontró información del estudiante.');
        }
        
        // Obtener el tutor asignado
        $tutorAsignado = $estudiante->tutorAsignado;
        
        if (!$tutorAsignado) {
            return redirect()->back()->with('error', 'No tienes un tutor asignado. Contacta al administrador.');
        }
        
        try {
            // Calcular hora de fin (1 hora después del inicio por defecto)
            $horaInicio = \Carbon\Carbon::createFromFormat('H:i', $request->hora_solicitada);
            $horaFin = $horaInicio->copy()->addHour();
            
            Cita::create([
                'estudiante_id' => $estudiante->id,
                'tutor_id' => $tutorAsignado->id,
                'titulo' => $request->tipo_cita,
                'descripcion' => $request->motivo,
                'fecha' => $request->fecha_solicitada,
                'hora_inicio' => $request->hora_solicitada,
                'hora_fin' => $horaFin->format('H:i'),
                'modalidad' => $request->modalidad,
                'status' => 'programada',
                'creado_por' => auth()->id()
            ]);
            
            return redirect()->back()->with('success', 'Cita solicitada exitosamente con tu tutor asignado. Espera la confirmación del profesor.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al agendar la cita: ' . $e->getMessage());
        }
    }

    public function cancelarCita($id)
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;
        
        if (!$estudiante) {
            abort(403, 'No autorizado');
        }
        
        $cita = $estudiante->citas()->findOrFail($id);
        
        if ($cita->status !== 'programada') {
            return redirect()->back()->with('error', 'Solo se pueden cancelar citas programadas.');
        }
        
        $cita->update(['status' => 'cancelada']);
        
        return redirect()->back()->with('success', 'Cita cancelada exitosamente.');
    }

    public function empresas(Request $request)
    {
        $query = Empresa::where('status', 'activa');
        
        // Filtros de búsqueda
        if ($request->filled('buscar')) {
            $query->where(function($q) use ($request) {
                $q->where('razon_social', 'like', '%' . $request->buscar . '%')
                  ->orWhere('nombre_comercial', 'like', '%' . $request->buscar . '%');
            });
        }
        
        if ($request->filled('sector')) {
            $query->where('sector', $request->sector);
        }
        
        if ($request->filled('ubicacion')) {
            $query->where('direccion', 'like', '%' . $request->ubicacion . '%');
        }
        
        $empresas = $query->with('estadias')->paginate(12);
        
        return view('estudiante.empresas', compact('empresas'));
    }

    public function postularEmpresa(Request $request, $empresaId)
    {
        $request->validate([
            'carta_presentacion' => 'required|string|max:1000',
            'acepta_terminos' => 'required|accepted'
        ]);
        
        $user = Auth::user();
        $estudiante = $user->estudiante;
        
        if (!$estudiante) {
            return redirect()->back()->with('error', 'No se encontró información del estudiante.');
        }
        
        $empresa = Empresa::findOrFail($empresaId);
        
        if ($empresa->estado !== 'activa') {
            return redirect()->back()->with('error', 'Esta empresa no está disponible para postulaciones.');
        }
        
        // Verificar si ya se postuló
        $postulacionExistente = $estudiante->estadias()
            ->where('empresa_id', $empresaId)
            ->where('status', 'pendiente')
            ->exists();
            
        if ($postulacionExistente) {
            return redirect()->back()->with('error', 'Ya tienes una postulación pendiente para esta empresa.');
        }
        
        try {
            Estadia::create([
                'estudiante_id' => $estudiante->id,
                'empresa_id' => $empresaId,
                'estado' => 'pendiente',
                'observaciones' => $request->carta_presentacion,
                'fecha_inicio' => null,
                'fecha_fin' => null
            ]);
            
            return redirect()->back()->with('success', 'Postulación enviada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al enviar la postulación: ' . $e->getMessage());
        }
    }

    public function perfil()
    {
        $user = Auth::user();
        $estudiante = $user->estudiante;
        $carreras = Carrera::where('activa', true)->get();
        
        // Estadísticas para el perfil
        $estadisticas = [
            'documentos' => $estudiante ? \App\Models\Documento::whereHas('estadia', function($query) use ($estudiante) {
                $query->where('estudiante_id', $estudiante->id);
            })->count() : 0,
            'citas' => $estudiante ? $estudiante->citas()->count() : 0,
            'estado_estadia' => $estudiante && $estudiante->estadias()->whereIn('estadias.status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])->exists() ? 'Activa' : 'Sin asignar'
        ];
        
        return view('estudiante.perfil', compact('user', 'estudiante', 'carreras', 'estadisticas'));
    }

    public function actualizarPerfil(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'matricula' => 'required|string|unique:estudiantes,matricula,' . (Auth::user()->estudiante->id ?? 'NULL'),
            'carrera_id' => 'required|exists:carreras,id',
            'semestre' => 'required|integer|min:1|max:12',
            'promedio' => 'nullable|numeric|min:0|max:10',
            'telefono' => 'nullable|string|max:20',
            'telefono_emergencia' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:500',
            'fecha_nacimiento' => 'nullable|date',
            'estado_civil' => 'nullable|in:soltero,casado,divorciado,viudo,union_libre'
        ]);
        
        $user = Auth::user();
        
        try {
            // Actualizar usuario
            $user->update([
                'name' => $request->name,
                'email' => $request->email
            ]);
            
            // Actualizar o crear estudiante
            $estudiante = $user->estudiante;
            if ($estudiante) {
                $estudiante->update([
                    'matricula' => $request->matricula,
                    'carrera_id' => $request->carrera_id,
                    'semestre' => $request->semestre,
                    'promedio' => $request->promedio,
                    'telefono' => $request->telefono,
                    'telefono_emergencia' => $request->telefono_emergencia,
                    'direccion' => $request->direccion,
                    'fecha_nacimiento' => $request->fecha_nacimiento,
                    'estado_civil' => $request->estado_civil
                ]);
            } else {
                Estudiante::create([
                    'user_id' => $user->id,
                    'matricula' => $request->matricula,
                    'carrera_id' => $request->carrera_id,
                    'semestre' => $request->semestre,
                    'promedio' => $request->promedio,
                    'telefono' => $request->telefono,
                    'telefono_emergencia' => $request->telefono_emergencia,
                    'direccion' => $request->direccion,
                    'fecha_nacimiento' => $request->fecha_nacimiento,
                    'estado_civil' => $request->estado_civil
                ]);
            }
            
            return redirect()->back()->with('success', 'Perfil actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el perfil: ' . $e->getMessage());
        }
    }

    public function cambiarPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|max:15|regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'new_password_confirmation' => 'required|same:new_password'
        ]);
        
        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'La contraseña actual es incorrecta.');
        }
        
        try {
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);
            
            return redirect()->back()->with('success', 'Contraseña cambiada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al cambiar la contraseña: ' . $e->getMessage());
        }
    }

    private function calcularProgresoEstadia($estadia)
    {
        if (!$estadia || !$estadia->fecha_inicio || !$estadia->fecha_fin) {
            return 0;
        }

        $fechaInicio = Carbon::parse($estadia->fecha_inicio);
        $fechaFin = Carbon::parse($estadia->fecha_fin);
        $fechaActual = Carbon::now();

        if ($fechaActual->lt($fechaInicio)) {
            return 0;
        }

        if ($fechaActual->gt($fechaFin)) {
            return 100;
        }

        $totalDias = $fechaInicio->diffInDays($fechaFin);
        $diasTranscurridos = $fechaInicio->diffInDays($fechaActual);

        return round(($diasTranscurridos / $totalDias) * 100, 1);
    }

    /**
     * Mostrar formulario para solicitar carta de presentación
     */
    public function cartaPresentacion()
    {
        $estudiante = auth()->user()->estudiante;
        $estadia = $estudiante->estadias()->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])->first();
        
        // Obtener la solicitud de carta de presentación activa con mayor progreso del estudiante
        $solicitudCarta = \App\Models\SolicitudCartaPresentacion::where('estudiante_id', $estudiante->id)
            ->where('estado', '!=', 'reemplazada')
            ->get()
            ->sortByDesc(function($solicitud) {
                // Priorizar por progreso, luego por fecha
                return $solicitud->progreso * 1000 + strtotime($solicitud->fecha_solicitud);
            })
            ->first();

        return view('estudiante.carta-presentacion', compact('estadia', 'solicitudCarta'));
    }

    /**
     * Procesar solicitud de carta de presentación
     */
    public function storeCartaPresentacion(Request $request)
    {
        $request->validate([
            'dirigida_a' => 'required|string|max:255',
            'cargo_destinatario' => 'nullable|string|max:255',
            'proposito' => 'required|string|in:inicio_estadia,presentacion_empresa,solicitud_practicas,otro',
            'proposito_otro' => 'required_if:proposito,otro|nullable|string|max:255',
            'observaciones' => 'nullable|string|max:1000'
        ], [
            'dirigida_a.required' => 'El campo "Dirigida a" es obligatorio.',
            'proposito.required' => 'Debes seleccionar el propósito de la carta.',
            'proposito_otro.required_if' => 'Debes especificar el propósito cuando seleccionas "Otro".'
        ]);

        $estudiante = auth()->user()->estudiante;
        $estadia = $estudiante->estadias()->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])->first();

        if (!$estadia) {
            return redirect()->back()->withErrors(['error' => 'No tienes una estadía activa asignada.']);
        }

        // Crear la solicitud de carta de presentación
        $solicitud = \App\Models\SolicitudCartaPresentacion::create([
            'estudiante_id' => $estudiante->id,
            'estadia_id' => $estadia->id,
            'dirigida_a' => $request->dirigida_a,
            'cargo_destinatario' => $request->cargo_destinatario,
            'proposito' => $request->proposito === 'otro' ? $request->proposito_otro : $request->proposito,
            'observaciones' => $request->observaciones,
            'estado' => 'pendiente',
            'fecha_solicitud' => now()
        ]);

        // Registrar actividad
        LogActividad::registrar(
            'Solicitud de carta de presentación creada',
            'Estudiante solicitó carta de presentación dirigida a: ' . $request->dirigida_a,
            [
                'tabla' => 'solicitudes_carta_presentacion',
                'registro_id' => $solicitud->id,
                'datos_anteriores' => null,
                'datos_nuevos' => $solicitud->toArray(),
                'tipo_usuario' => 'estudiante'
            ]
        );

        return redirect()->route('student.carta-presentacion')
                        ->with('success', 'Tu solicitud de carta de presentación ha sido enviada correctamente. Será procesada por el coordinador académico.');
    }

    /**
     * Mostrar formulario para solicitar carta de presentación
     */
    public function solicitarCartaPresentacion()
    {
        $estudiante = auth()->user()->estudiante;
        $estadia = $estudiante->estadias()->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])->first();

        if (!$estadia) {
            return redirect()->route('student.carta-presentacion')
                           ->withErrors(['error' => 'No tienes una estadía activa asignada.']);
        }

        return view('estudiante.solicitar-carta-presentacion', compact('estadia'));
    }

    /**
     * Procesar solicitud de carta de presentación (método simplificado)
     */
    public function procesarSolicitudCarta(Request $request)
    {
        $estudiante = auth()->user()->estudiante;
        $estadia = $estudiante->estadias()->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])->first();

        if (!$estadia) {
            return redirect()->back()->withErrors(['error' => 'No tienes una estadía activa asignada.']);
        }

        // Verificar si ya existe una solicitud pendiente o aprobada (excluir rechazadas)
        $solicitudExistente = \App\Models\SolicitudCartaPresentacion::where('estudiante_id', $estudiante->id)
            ->whereIn('estado', ['pendiente', 'aprobada_profesor', 'aprobada_director', 'generada'])
            ->first();

        if ($solicitudExistente) {
            return redirect()->back()->withErrors(['error' => 'Ya tienes una solicitud de carta de presentación en proceso.']);
        }

        // Si hay una solicitud rechazada, marcarla como reemplazada
        $solicitudRechazada = \App\Models\SolicitudCartaPresentacion::where('estudiante_id', $estudiante->id)
            ->whereIn('estado', ['rechazada_profesor', 'rechazada_director'])
            ->orderBy('fecha_solicitud', 'desc')
            ->first();

        if ($solicitudRechazada) {
            $solicitudRechazada->update(['estado' => 'reemplazada']);
        }

        // Crear la solicitud de carta de presentación automáticamente
        $solicitud = \App\Models\SolicitudCartaPresentacion::create([
            'estudiante_id' => $estudiante->id,
            'estadia_id' => $estadia->id,
            'dirigida_a' => $estadia->empresa->nombre ?? 'Empresa asignada',
            'cargo_destinatario' => 'Recursos Humanos',
            'proposito' => 'Presentación para inicio de estadía profesional',
            'observaciones' => 'Solicitud generada automáticamente',
            'estado' => 'pendiente',
            'fecha_solicitud' => now()
        ]);

        // Registrar actividad
        LogActividad::registrar(
            'Solicitud de carta de presentación creada',
            'Estudiante solicitó carta de presentación automáticamente',
            [
                'tabla' => 'solicitudes_carta_presentacion',
                'registro_id' => $solicitud->id,
                'datos_anteriores' => null,
                'datos_nuevos' => $solicitud->toArray(),
                'tipo_usuario' => 'estudiante'
            ]
        );

        return redirect()->route('student.carta-presentacion')
                        ->with('success', 'Tu solicitud de carta de presentación ha sido enviada correctamente.');
    }

    /**
     * Mostrar formulario para editar proyecto y área de la estadía
     */
    public function editarProyecto()
    {
        $estudiante = auth()->user()->estudiante;
        $estadia = $estudiante->estadias()->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])->first();

        if (!$estadia) {
            return redirect()->route('student.dashboard')
                           ->withErrors(['error' => 'No tienes una estadía activa asignada.']);
        }

        return view('estudiante.editar-proyecto', compact('estadia'));
    }

    /**
     * Actualizar proyecto y área de la estadía
     */
    public function actualizarProyecto(Request $request)
    {
        $request->validate([
            'proyecto' => 'required|string|max:200',
            'area_empresa' => 'required|string|max:100'
        ], [
            'proyecto.required' => 'El campo proyecto es obligatorio.',
            'proyecto.max' => 'El proyecto no puede exceder 200 caracteres.',
            'area_empresa.required' => 'El campo área de la empresa es obligatorio.',
            'area_empresa.max' => 'El área no puede exceder 100 caracteres.'
        ]);

        $estudiante = auth()->user()->estudiante;
        $estadia = $estudiante->estadias()->whereIn('status', ['en_proceso', 'documentos_pendientes', 'documentos_completos', 'validacion_biblioteca'])->first();

        if (!$estadia) {
            return redirect()->back()->withErrors(['error' => 'No tienes una estadía activa asignada.']);
        }

        $estadia->update([
            'proyecto' => $request->proyecto,
            'area_empresa' => $request->area_empresa
        ]);

        // Registrar actividad
        LogActividad::registrar(
            'Proyecto y área de estadía actualizados',
            'Estudiante actualizó información del proyecto y área de la estadía',
            [
                'tabla' => 'estadias',
                'registro_id' => $estadia->id,
                'datos_anteriores' => $estadia->toArray(),
                'datos_nuevos' => $estadia->fresh()->toArray(),
                'tipo_usuario' => 'estudiante'
            ]
        );

        return redirect()->route('student.carta-presentacion.solicitar')
                        ->with('success', 'Proyecto y área actualizados correctamente. Ahora puedes solicitar tu carta de presentación.');
    }

    /**
     * Generar y descargar PDF de carta de presentación
     */
    public function descargarCartaPresentacion($id)
    {
        $solicitud = \App\Models\SolicitudCartaPresentacion::with(['estudiante.user', 'estudiante.carrera', 'estudiante.especialidad', 'estadia.empresa'])
            ->where('id', $id)
            ->where('estudiante_id', auth()->user()->estudiante->id)
            ->firstOrFail();

        // Verificar que la carta esté aprobada por el director
        if (!in_array($solicitud->estado, ['aprobada_director', 'generada'])) {
            return redirect()->back()->withErrors(['error' => 'La carta de presentación aún no ha sido aprobada.']);
        }

        // Si existe archivo firmado, descargarlo directamente
        if ($solicitud->archivo_firmado && \Storage::disk('public')->exists($solicitud->archivo_firmado)) {
            $fileName = 'Carta_Presentacion_Firmada_' . $solicitud->estudiante->matricula . '_' . date('Y-m-d') . '.pdf';
            return \Storage::disk('public')->download($solicitud->archivo_firmado, $fileName);
        }

        // Si no hay archivo firmado, generar PDF básico
        $director = $solicitud->estudiante->carrera->director ?? null;
        $pdf = \PDF::loadView('pdf.carta-presentacion', compact('solicitud', 'director'));
        $pdf->setPaper('letter', 'portrait');

        // Actualizar estado a generada si no lo está
        if ($solicitud->estado !== 'generada') {
            $solicitud->update(['estado' => 'generada']);
        }

        $fileName = 'Carta_Presentacion_' . $solicitud->estudiante->matricula . '_' . date('Y-m-d') . '.pdf';
        return $pdf->download($fileName);
    }

    /**
     * Obtener nombre legible del tipo de documento
     */
    private function getNombreDocumento($tipo)
    {
        $nombres = [
            'propuesta' => 'Propuesta de Estadía',
            'reporte_parcial' => 'Reporte Parcial',
            'reporte_final' => 'Reporte Final',
            'carta_aceptacion' => 'Carta de Aceptación',
            'carta_presentacion' => 'Carta de Presentación'
        ];
        
        return $nombres[$tipo] ?? ucfirst(str_replace('_', ' ', $tipo));
    }

    /**
     * Calcular fecha límite para documentos según el tipo y la estadía
     */
    private function getFechaLimiteDocumento($tipo, $estadia)
    {
        if (!$estadia->fecha_inicio || !$estadia->fecha_fin) {
            return null;
        }
        
        $fechaInicio = \Carbon\Carbon::parse($estadia->fecha_inicio);
        $fechaFin = \Carbon\Carbon::parse($estadia->fecha_fin);
        
        switch ($tipo) {
            case 'propuesta':
                return $fechaInicio->copy()->subWeeks(2)->format('Y-m-d');
            case 'carta_aceptacion':
                return $fechaInicio->copy()->subWeek()->format('Y-m-d');
            case 'reporte_parcial':
                return $fechaInicio->copy()->addWeeks(6)->format('Y-m-d');
            case 'reporte_final':
                return $fechaFin->copy()->addWeek()->format('Y-m-d');
            default:
                return null;
        }
    }

    /**
     * Mostrar la página de formatos disponibles
     */
    public function formatosDisponibles()
    {
        return view('estudiante.formatos-disponibles');
    }

    public function empresasCatalogo()
    {
        return view('estudiante.empresas-catalogo');
    }
}
