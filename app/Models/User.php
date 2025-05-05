<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'primer_apellido',
        'segundo_apellido',
        'email',
        'password',
        'id_rol',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    /**
     * Obtener el rol del usuario.
     */
    public function rol()
    {
        return $this->belongsTo(Role::class, 'id_rol');
    }
    
    /**
     * Verificar si el usuario tiene un rol específico.
     */
    public function hasRole($rolNombre)
{
        // Si no tenemos un id_rol, claramente no tenemos el rol solicitado
        if (!$this->id_rol) {
            return false;
        }
        
        // Cargar el rol si aún no se ha cargado
        if (!$this->relationLoaded('rol')) {
            $this->load('rol');
        }
        
        // Si después de intentar cargar no hay rol, devolver false
        if (!$this->rol) {
            // Intenta buscar el rol directamente para debug
            $rolDirecto = \App\Models\Role::find($this->id_rol);
            \Illuminate\Support\Facades\Log::debug('Rol no cargado para usuario ' . $this->id . '. ID rol: ' . $this->id_rol . '. Rol directo: ' . ($rolDirecto ? $rolDirecto->nombre : 'No encontrado'));
            return false;
        }
        
        // Comparar el nombre del rol
        $coincide = $this->rol->nombre === $rolNombre;
        \Illuminate\Support\Facades\Log::debug('Verificando rol para usuario ' . $this->id . ': ' . $this->rol->nombre . ' == ' . $rolNombre . '? ' . ($coincide ? 'Sí' : 'No'));
        
        return $coincide;
    }
    
    /**
     * Obtener el nombre completo del usuario.
     */
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->primer_apellido . 
            ($this->segundo_apellido ? ' ' . $this->segundo_apellido : '');
    }
    
    /**
     * Obtener expedientes creados por el usuario.
     */
    public function expedientes()
    {
        return $this->hasMany(Expediente::class, 'id_usuario_registra');
    }
}