<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 font-weight-bold">
                {{ __('Editar Expediente') }}
            </h2>
            <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Editar Expediente: {{ $expediente->numero_expediente }}</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('expedientes.update', $expediente) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="numero_expediente" class="form-label">Número de Expediente</label>
                                <input type="text" class="form-control" id="numero_expediente" name="numero_expediente" 
                                       value="{{ old('numero_expediente', $expediente->numero_expediente) }}" 
                                       readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label for="asunto" class="form-label">Asunto *</label>
                                <textarea class="form-control @error('asunto') is-invalid @enderror" id="asunto" name="asunto" rows="3" required>{{ old('asunto', $expediente->asunto) }}</textarea>
                                @error('asunto')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="fecha_inicio" class="form-label">Fecha de Inicio *</label>
                                <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" id="fecha_inicio" name="fecha_inicio" 
                                       value="{{ old('fecha_inicio', $expediente->fecha_inicio->format('Y-m-d')) }}" required>
                                @error('fecha_inicio')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="id_estatus" class="form-label">Estatus *</label>
                                <select class="form-select @error('id_estatus') is-invalid @enderror" id="id_estatus" name="id_estatus" required>
                                    <option value="">Seleccionar estatus</option>
                                    @foreach($estatus as $status)
                                        <option value="{{ $status->id }}" {{ old('id_estatus', $expediente->id_estatus) == $status->id ? 'selected' : '' }}>
                                            {{ ucfirst($status->nombre) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_estatus')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="d-flex justify-content-end mt-4">
                                <a href="{{ route('expedientes.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Actualizar Expediente</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>