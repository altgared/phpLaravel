<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
    ];
    
    /**
     * Obtener los usuarios que pertenecen a este rol.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_rol');
    }
}