<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold">
                {{ __('Detalles del Expediente') }}
            </h2>
            <div>
                @can('update', $expediente)
                <a href="{{ route('expedientes.edit', $expediente) }}" class="btn btn-primary me-2">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                @endcan
                <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Expediente {{ $expediente->numero_expediente }}</h3>
                        @if($expediente->deleted_at)
                            <span class="badge bg-danger ms-2">Eliminado</span>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Número de Expediente:</div>
                            <div class="col-md-8">{{ $expediente->numero_expediente }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Asunto:</div>
                            <div class="col-md-8">{{ $expediente->asunto }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Fecha de Inicio:</div>
                            <div class="col-md-8">{{ $expediente->fecha_inicio->format('d/m/Y') }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Estatus:</div>
                            <div class="col-md-8">
                                <span class="badge 
                                    @if($expediente->estatus->nombre == 'abierto') bg-success 
                                    @elseif($expediente->estatus->nombre == 'en proceso') bg-warning text-dark 
                                    @else bg-info 
                                    @endif">
                                    {{ ucfirst($expediente->estatus->nombre) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Registrado por:</div>
                            <div class="col-md-8">{{ $expediente->usuarioRegistra->nombre_completo }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Fecha de Registro:</div>
                            <div class="col-md-8">{{ $expediente->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Última Actualización:</div>
                            <div class="col-md-8">{{ $expediente->updated_at->format('d/m/Y H:i') }}</div>
                        </div>
                        
                        @if($expediente->deleted_at)
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Fecha de Eliminación:</div>
                            <div class="col-md-8">{{ $expediente->deleted_at->format('d/m/Y H:i') }}</div>
                        </div>
                        @endif
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        @if($expediente->deleted_at)
                            @can('restore', $expediente)
                                <form action="{{ route('expedientes.restore', $expediente) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success me-2">
                                        <i class="bi bi-arrow-counterclockwise"></i> Restaurar
                                    </button>
                                </form>
                            @endcan
                        @else
                            @can('delete', $expediente)
                                <form action="{{ route('expedientes.destroy', $expediente) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger me-2" 
                                            onclick="return confirm('¿Estás seguro de que quieres eliminar este expediente?')">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            @endcan
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>