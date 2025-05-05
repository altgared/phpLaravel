<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estatus extends Model
{
    use HasFactory;
    
    /**
     * Nombre de la tabla en plural en español
     */
    protected $table = 'estatus';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
    ];
    
    /**
     * Obtener los expedientes con este estatus.
     */
    public function expedientes()
    {
        return $this->hasMany(Expediente::class, 'id_estatus');
    }
}