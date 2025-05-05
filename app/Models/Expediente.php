<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expediente extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'numero_expediente',
        'asunto',
        'fecha_inicio',
        'id_estatus',
        'id_usuario_registra',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_inicio' => 'date',
    ];
    
    /**
     * Obtener el estatus del expediente.
     */
    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'id_estatus');
    }
    
    /**
     * Obtener el usuario que registró el expediente.
     */
    public function usuarioRegistra()
    {
        return $this->belongsTo(User::class, 'id_usuario_registra');
    }
    
    /**
     * Generar automáticamente un número de expediente.
     * Formato: 00001/2023, 00002/2023, etc.
     */
    public static function generarNumeroExpediente()
    {
        $año = date('Y');
        $ultimoExpediente = self::where('numero_expediente', 'like', "%/$año")
            ->orderBy('id', 'desc')
            ->first();
            
        $consecutivo = 1;
        
        if ($ultimoExpediente) {
            $partes = explode('/', $ultimoExpediente->numero_expediente);
            $consecutivo = (int)$partes[0] + 1;
        }
        
        return sprintf('%05d/%s', $consecutivo, $año);
    }
}