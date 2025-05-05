@props(['expedientes', 'estatus', 'canDelete' => false, 'showTrashed' => false])

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Expedientes</h3>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Número</th>
                        <th>Asunto</th>
                        <th>Fecha Inicio</th>
                        <th>Estatus</th>
                        <th>Registrado por</th>
                        <th>Acciones</th>
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
                            <td>{{ $expediente->usuarioRegistra->nombre_completo }}</td>
                            <td>
                                <div class="btn-group">
                                    @can('view', $expediente)
                                        <a href="{{ route('expedientes.show', $expediente) }}" class="btn btn-sm btn-info me-1">
                                            <i class="bi bi-eye"></i> Ver
                                        </a>
                                    @endcan
                                    
                                    @can('update', $expediente)
                                        <a href="{{ route('expedientes.edit', $expediente) }}" class="btn btn-sm btn-primary me-1">
                                            <i class="bi bi-pencil"></i> Editar
                                        </a>
                                    @endcan
                                    
                                    @if ($canDelete && !$expediente->deleted_at)
                                        @can('delete', $expediente)
                                            <form action="{{ route('expedientes.destroy', $expediente) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" 
                                                        onclick="return confirm('¿Estás seguro de que quieres eliminar este expediente?')">
                                                    <i class="bi bi-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        @endcan
                                    @endif
                                    
                                    @if ($showTrashed && $expediente->deleted_at)
                                        @can('restore', $expediente)
                                            <form action="{{ route('expedientes.restore', $expediente) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success">
                                                    <i class="bi bi-arrow-counterclockwise"></i> Restaurar
                                                </button>
                                            </form>
                                        @endcan
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay expedientes disponibles</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $expedientes->links() }}
    </div>
</div>