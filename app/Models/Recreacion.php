<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recreacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'razon_social', 
        'establecimientos', 
        'telefono', 
        'correo', 
        'direccion_principal', 
        'estado', 
        'usuario_creacion', 
        'usuario_modificacion', 
        'id_municipio', 
        'id_representantes'
    ];

    public function UsuarioCreador() 
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function UsuarioModificador() 
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function Municipio() 
    {
    	return $this->belongsTo(Municipio::class, 'id_municipio');
    }

    public function Representante() 
    {
        return $this->belongsTo(Representante::class, 'id_representantes');
    }
}
