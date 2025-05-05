<?php

namespace App\Services;

use App\Models\Expediente;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ExpedienteService
{
    /**
     * Obtener expedientes con filtros aplicados
     */
    public function getExpedientes(array $filters = [], User $user = null, bool $withTrashed = false): LengthAwarePaginator
    {
        $query = Expediente::query()
            ->with(['estatus', 'usuarioRegistra'])
            ->when(!$user->hasRole('Administrador'), function (Builder $query) use ($user) {
                $query->where('id_usuario_registra', $user->id);
            })
            ->when($withTrashed, function (Builder $query) {
                $query->withTrashed();
            });
        
        // Aplicar filtros
        $this->applyFilters($query, $filters);
        
        return $query->latest()->paginate(10);
    }
    
    /**
     * Crear un nuevo expediente
     */
    public function createExpediente(array $data, User $user): Expediente
    {
        return DB::transaction(function () use ($data, $user) {
            $data['numero_expediente'] = Expediente::generarNumeroExpediente();
            $data['id_usuario_registra'] = $user->id;
            
            return Expediente::create($data);
        });
    }
    
    /**
     * Actualizar un expediente existente
     */
    public function updateExpediente(Expediente $expediente, array $data): Expediente
    {
        $expediente->update($data);
        return $expediente->fresh();
    }
    
    /**
     * Eliminar lógicamente un expediente
     */
    public function deleteExpediente(Expediente $expediente): bool
    {
        return $expediente->delete();
    }
    
    /**
     * Restaurar un expediente eliminado
     */
    public function restoreExpediente(Expediente $expediente): bool
    {
        return $expediente->restore();
    }
    
    /**
     * Aplicar filtros a la consulta
     */
    protected function applyFilters(Builder $query, array $filters): void
    {
        // Filtro por estatus
        if (!empty($filters['estatus'])) {
            $query->where('id_estatus', $filters['estatus']);
        }
        
        // Filtro por rango de fechas
        if (!empty($filters['fecha_inicio'])) {
            $query->whereDate('fecha_inicio', '>=', $filters['fecha_inicio']);
        }
        
        if (!empty($filters['fecha_fin'])) {
            $query->whereDate('fecha_inicio', '<=', $filters['fecha_fin']);
        }
        
        // Búsqueda por número o asunto
        if (!empty($filters['busqueda'])) {
            $search = $filters['busqueda'];
            $query->where(function (Builder $query) use ($search) {
                $query->where('numero_expediente', 'LIKE', "%{$search}%")
                      ->orWhere('asunto', 'LIKE', "%{$search}%");
            });
        }
    }
}