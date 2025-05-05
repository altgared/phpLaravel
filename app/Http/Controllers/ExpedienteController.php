<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpedienteCreateRequest;
use App\Http\Requests\ExpedienteUpdateRequest;
use App\Models\Estatus;
use App\Models\Expediente;
use App\Services\ExpedienteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Log;

class ExpedienteController extends Controller
{
    protected $expedienteService;
    
    /**
     * Constructor con inyección de dependencias
     */
    public function __construct(ExpedienteService $expedienteService)
    {
        $this->expedienteService = $expedienteService;
    }
    
    /**
     * Mostrar la lista de expedientes.
     */
    public function index(Request $request)
    {
        if (Gate::denies('viewAny', Expediente::class)) {
            abort(403, 'No tienes permiso para ver expedientes.');
        }
        
        $filters = $request->only(['estatus', 'fecha_inicio', 'fecha_fin', 'busqueda']);
        $incluirEliminados = $request->boolean('incluir_eliminados') && Auth::user()->can('viewTrashed', Expediente::class);
        
        $expedientes = $this->expedienteService->getExpedientes($filters, Auth::user(), $incluirEliminados);
        $estatus = Estatus::all();
        
        return view('expedientes.index', compact('expedientes', 'estatus'));
    }

    /**
     * Mostrar el formulario para crear un nuevo expediente.
     */
    public function create()
    {
        if (Gate::denies('create', Expediente::class)) {
            abort(403, 'No tienes permiso para crear expedientes.');
        }
        
        $estatus = Estatus::all();
        return view('expedientes.create', compact('estatus'));
    }

    /**
     * Almacenar un nuevo expediente en la base de datos.
     */
    public function store(ExpedienteCreateRequest $request)
    {
        // La autorización ya se maneja en el FormRequest
        
        $expediente = $this->expedienteService->createExpediente(
            $request->validated(),
            Auth::user()
        );
        
        return redirect()->route('expedientes.show', $expediente)
            ->with('success', 'Expediente creado correctamente.');
    }

    /**
     * Mostrar un expediente específico.
     */
    public function show(Expediente $expediente)
    {
        if (Gate::denies('view', $expediente)) {
            abort(403, 'No tienes permiso para ver este expediente.');
        }
        
        return view('expedientes.show', compact('expediente'));
    }

    /**
     * Mostrar el formulario para editar un expediente.
     */
    public function edit(Expediente $expediente)
    {
        // Depuración
        \Illuminate\Support\Facades\Log::debug('Usuario: ' . auth()->id() . ', Rol: ' . auth()->user()->id_rol);
        \Illuminate\Support\Facades\Log::debug('Expediente ID: ' . $expediente->id . ', Creado por: ' . $expediente->id_usuario_registra);
        
        $resultado = Gate::allows('update', $expediente);
        \Illuminate\Support\Facades\Log::debug('Gate::allows(update) resultado: ' . ($resultado ? 'true' : 'false'));
        
        if (!$resultado) {
            abort(403, 'No tienes permiso para editar este expediente.');
        }
        
        $estatus = Estatus::all();
        return view('expedientes.edit', compact('expediente', 'estatus'));
    }

    /**
     * Actualizar un expediente en la base de datos.
     */
    public function update(ExpedienteUpdateRequest $request, Expediente $expediente)
    {
        // La autorización ya se maneja en el FormRequest
        
        $expediente = $this->expedienteService->updateExpediente(
            $expediente,
            $request->validated()
        );
        
        return redirect()->route('expedientes.show', $expediente)
            ->with('success', 'Expediente actualizado correctamente.');
    }

    /**
     * Eliminar un expediente de la base de datos (soft delete).
     */
    public function destroy(Expediente $expediente)
    {
        if (Gate::denies('delete', $expediente)) {
            abort(403, 'No tienes permiso para eliminar este expediente.');
        }
        
        $this->expedienteService->deleteExpediente($expediente);
        
        return redirect()->route('expedientes.index')
            ->with('success', 'Expediente eliminado correctamente.');
    }
    
    /**
     * Restaurar un expediente eliminado.
     */
    public function restore(Expediente $expediente)
    {
        if (Gate::denies('restore', $expediente)) {
            abort(403, 'No tienes permiso para restaurar este expediente.');
        }
        
        $this->expedienteService->restoreExpediente($expediente);
        
        return redirect()->route('expedientes.show', $expediente)
            ->with('success', 'Expediente restaurado correctamente.');
    }
}