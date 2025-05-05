<?php

namespace App\Policies;

use App\Models\Expediente;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Log;

class ExpedientePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Todos los usuarios autenticados pueden ver la lista de expedientes
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Expediente $expediente): bool
    {
        // Admin puede ver cualquier expediente
        if ($user->hasRole('Administrador')) {
            return true;
        }
        
        // Usuario normal solo puede ver sus propios expedientes
        return $user->id === $expediente->id_usuario_registra;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Todos los usuarios autenticados pueden crear expedientes
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Expediente $expediente): bool
    {
        // Admin puede actualizar cualquier expediente
             
        if ($user->hasRole('Administrador')) {
            return true;
        }
        
        // Usuario normal solo puede actualizar sus propios expedientes
        return $user->id === $expediente->id_usuario_registra;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Expediente $expediente): bool
    {
        // Solo el administrador puede eliminar expedientes
        return $user->hasRole('Administrador');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Expediente $expediente): bool
    {
        // Solo el administrador puede restaurar expedientes eliminados
        return $user->hasRole('Administrador');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Expediente $expediente): bool
    {
        // Solo el administrador puede eliminar permanentemente expedientes
        return $user->hasRole('Administrador');
    }
    
    /**
     * Determine whether the user can see trashed models.
     */
    public function viewTrashed(User $user): bool
    {
        // Solo el administrador puede ver expedientes eliminados
        return $user->hasRole('Administrador');
    }
}