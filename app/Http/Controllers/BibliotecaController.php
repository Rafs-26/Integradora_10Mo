<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use App\Models\Estudiante;
use App\Models\Estadia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BibliotecaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Biblioteca');
    }

    /**
     * Mostrar el dashboard de biblioteca
     */
    public function dashboard()
    {
        // Obtener estadísticas de memorias
        $memoriasPendientes = Documento::where('tipo_documento', 'memoria_estadia')
            ->where('status', 'pendiente')
            ->count();
            
        $memoriasValidadas = Documento::where('tipo_documento', 'memoria_estadia')
            ->where('status', 'validado')
            ->whereMonth('updated_at', now()->month)
            ->count();
            
        $memoriasRechazadas = Documento::where('tipo_documento', 'memoria_estadia')
            ->where('status', 'rechazado')
            ->count();
            
        $totalProcesadas = $memoriasValidadas + $memoriasRechazadas;
        
        // Obtener memorias pendientes recientes para la tabla
        $memoriasPendientesRecientes = Documento::with(['estudiante.user', 'estudiante.carrera', 'estadia.empresa'])
            ->where('tipo_documento', 'memoria_estadia')
            ->where('status', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('biblioteca.dashboard', compact(
            'memoriasPendientes',
            'memoriasValidadas', 
            'memoriasRechazadas',
            'totalProcesadas',
            'memoriasPendientesRecientes'
        ));
    }

    /**
     * Mostrar todas las memorias pendientes
     */
    public function memoriasPendientes()
    {
        $memorias = Documento::with(['estudiante.user', 'estudiante.carrera', 'estadia.empresa'])
            ->where('tipo_documento', 'memoria_estadia')
            ->where('status', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('biblioteca.memorias-pendientes', compact('memorias'));
    }

    /**
     * Mostrar todas las memorias validadas
     */
    public function memoriasValidadas()
    {
        $memorias = Documento::with(['estudiante.user', 'estudiante.carrera', 'estadia.empresa'])
            ->where('tipo_documento', 'memoria_estadia')
            ->where('status', 'validado')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
            
        return view('biblioteca.memorias-validadas', compact('memorias'));
    }

    /**
     * Mostrar todas las memorias rechazadas
     */
    public function memoriasRechazadas()
    {
        $memorias = Documento::with(['estudiante.user', 'estudiante.carrera', 'estadia.empresa'])
            ->where('tipo_documento', 'memoria_estadia')
            ->where('status', 'rechazado')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
            
        return view('biblioteca.memorias-rechazadas', compact('memorias'));
    }

    /**
     * Mostrar detalles de una memoria para revisión
     */
    public function revisarMemoria($id)
    {
        $documento = Documento::with(['estudiante.user', 'estudiante.carrera', 'estadia.empresa'])
            ->where('tipo_documento', 'memoria_estadia')
            ->findOrFail($id);
            
        return view('biblioteca.revisar-memoria', compact('documento'));
    }

    /**
     * Validar una memoria
     */
    public function validarMemoria(Request $request, $id)
    {
        $request->validate([
            'comentarios' => 'nullable|string|max:1000'
        ]);
        
        $documento = Documento::where('tipo_documento', 'memoria_estadia')
            ->findOrFail($id);
            
        $documento->update([
            'status' => 'validado',
            'comentarios_validacion' => $request->comentarios,
            'validado_por' => Auth::id(),
            'fecha_validacion' => now()
        ]);
        
        // Crear notificación para el estudiante
        $documento->estudiante->user->notificaciones()->create([
            'titulo' => 'Memoria de Estadía Validada',
            'mensaje' => 'Tu memoria de estadía ha sido validada por biblioteca.',
            'tipo' => 'validacion_memoria',
            'leida' => false
        ]);
        
        return redirect()->route('biblioteca.memorias-pendientes')
            ->with('success', 'Memoria validada exitosamente.');
    }

    /**
     * Rechazar una memoria
     */
    public function rechazarMemoria(Request $request, $id)
    {
        $request->validate([
            'comentarios' => 'required|string|max:1000'
        ]);
        
        $documento = Documento::where('tipo_documento', 'memoria_estadia')
            ->findOrFail($id);
            
        $documento->update([
            'status' => 'rechazado',
            'comentarios_validacion' => $request->comentarios,
            'validado_por' => Auth::id(),
            'fecha_validacion' => now()
        ]);
        
        // Crear notificación para el estudiante
        $documento->estudiante->user->notificaciones()->create([
            'titulo' => 'Memoria de Estadía Rechazada',
            'mensaje' => 'Tu memoria de estadía ha sido rechazada. Revisa los comentarios y vuelve a subirla.',
            'tipo' => 'rechazo_memoria',
            'leida' => false
        ]);
        
        return redirect()->route('biblioteca.memorias-pendientes')
            ->with('success', 'Memoria rechazada. Se ha notificado al estudiante.');
    }

    /**
     * Reactivar una memoria rechazada
     */
    public function reactivarMemoria($id)
    {
        $documento = Documento::where('tipo_documento', 'memoria_estadia')
            ->findOrFail($id);
        
        $documento->update([
            'status' => 'pendiente',
            'comentarios_validacion' => null,
            'fecha_validacion' => null,
            'validado_por' => null
        ]);

        // Crear notificación para el estudiante
        $documento->estudiante->user->notificaciones()->create([
            'titulo' => 'Memoria Reactivada para Revisión',
            'mensaje' => 'Tu memoria de estadía ha sido reactivada y está nuevamente en proceso de revisión.',
            'tipo' => 'reactivacion_memoria',
            'leida' => false
        ]);

        return redirect()->route('biblioteca.memorias-rechazadas')
                        ->with('success', 'Memoria reactivada correctamente para nueva revisión.');
    }

    /**
     * Descargar archivo de memoria
     */
    public function descargarMemoria($id)
    {
        $documento = Documento::where('tipo_documento', 'memoria_estadia')
            ->findOrFail($id);
            
        if (!Storage::exists($documento->ruta_archivo)) {
            return redirect()->back()->with('error', 'El archivo no existe.');
        }
        
        return Storage::download($documento->ruta_archivo, $documento->nombre_archivo);
    }

    /**
     * Mostrar estadísticas de validación
     */
    public function estadisticas()
    {
        $estadisticas = [
            'total_memorias' => Documento::where('tipo_documento', 'memoria_estadia')->count(),
            'validadas' => Documento::where('tipo_documento', 'memoria_estadia')
                ->where('status', 'validado')->count(),
            'rechazadas' => Documento::where('tipo_documento', 'memoria_estadia')
                ->where('status', 'rechazado')->count(),
            'pendientes' => Documento::where('tipo_documento', 'memoria_estadia')
                ->where('status', 'pendiente')->count(),
        ];
        
        // Estadísticas por mes
        $estadisticasMensuales = Documento::where('tipo_documento', 'memoria_estadia')
            ->selectRaw('MONTH(created_at) as mes, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();
            
        return view('biblioteca.estadisticas', compact('estadisticas', 'estadisticasMensuales'));
    }
}