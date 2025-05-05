<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center py-2">
            <h2 class="fs-4 fw-semibold m-0 text-dark">
                <i class="bi bi-folder2-open"></i> {{ __('Expedientes') }}
            </h2>
            @can('create', App\Models\Expediente::class)
                <a href="{{ route('expedientes.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Nuevo Expediente
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center py-3">
                        <h5 class="m-0">
                            <i class="bi bi-funnel"></i> Filtros
                        </h5>
                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFilters">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>
                    <div class="card-body collapse show" id="collapseFilters">
                        <form action="{{ route('expedientes.index') }}" method="GET" class="row g-3">
                            <div class="col-md-3">
                                <label for="estatus" class="form-label fw-semibold">Estatus</label>
                                <select class="form-select" id="estatus" name="estatus">
                                    <option value="">Todos</option>
                                    @foreach($estatus as $status)
                                        <option value="{{ $status->id }}" {{ request('estatus') == $status->id ? 'selected' : '' }}>
                                            {{ ucfirst($status->nombre) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-md-3">
                                <label for="fecha_inicio" class="form-label fw-semibold">Desde</label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
                            </div>
                            
                            <div class="col-md-3">
                                <label for="fecha_fin" class="form-label fw-semibold">Hasta</label>
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="{{ request('fecha_fin') }}">
                            </div>
                            
                            <div class="col-md-3">
                                <label for="busqueda" class="form-label fw-semibold">Búsqueda</label>
                                <input type="text" class="form-control" id="busqueda" name="busqueda" 
                                       placeholder="Número o Asunto" value="{{ request('busqueda') }}">
                            </div>
                            
                            @can('viewTrashed', App\Models\Expediente::class)
                                <div class="col-md-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="incluir_eliminados" name="incluir_eliminados" 
                                               value="1" {{ request('incluir_eliminados') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="incluir_eliminados">
                                            Incluir expedientes eliminados
                                        </label>
                                    </div>
                                </div>
                            @endcan
                            
                            <div class="col-12 d-flex justify-content-end mt-4">
                                <a href="{{ route('expedientes.index') }}" class="btn btn-light me-2">
                                    <i class="bi bi-eraser"></i> Limpiar
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-funnel"></i> Filtrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header py-3">
                        <h5 class="m-0"><i class="bi bi-list-ul"></i> Lista de Expedientes</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Número</th>
                                        <th>Asunto</th>
                                        <th>Fecha Inicio</th>
                                        <th>Estatus</th>
                                        <th>Registrado por</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($expedientes as $expediente)
                                        <tr class="{{ $expediente->deleted_at ? 'table-secondary' : '' }}">
                                            <td>{{ $expediente->numero_expediente }}</td>
                                            <td>{{ Str::limit($expediente->asunto, 50) }}</td>
                                            <td>{{ $expediente->fecha_inicio->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($expediente->estatus->nombre == 'abierto') bg-success 
                                                    @elseif($expediente->estatus->nombre == 'en proceso') bg-warning text-dark 
                                                    @else bg-info 
                                                    @endif">
                                                    {{ ucfirst($expediente->estatus->nombre) }}
                                                </span>
                                            </td>
                                            <td>{{ $expediente->usuarioRegistra->nombre_completo ?? $expediente->usuarioRegistra->nombre }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    @can('view', $expediente)
                                                        <a href="{{ route('expedientes.show', $expediente) }}" class="btn btn-sm btn-info" title="Ver">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    @endcan
                                                    
                                                    @can('update', $expediente)
                                                        <a href="{{ route('expedientes.edit', $expediente) }}" class="btn btn-sm btn-primary" title="Editar">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                    @endcan
                                                    
                                                    @if (!$expediente->deleted_at)
                                                        @can('delete', $expediente)
                                                            <form action="{{ route('expedientes.destroy', $expediente) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"
                                                                        onclick="return confirm('¿Estás seguro de eliminar este expediente?')">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    @endif
                                                    
                                                    @if ($expediente->deleted_at)
                                                        @can('restore', $expediente)
                                                            <form action="{{ route('expedientes.restore', $expediente) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button type="submit" class="btn btn-sm btn-success" title="Restaurar">
                                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4 text-muted">No hay expedientes disponibles</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if(isset($expedientes) && method_exists($expedientes, 'hasPages') && $expedientes->hasPages())
                    <div class="card-footer d-flex justify-content-center">
                        {{ $expedientes->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>