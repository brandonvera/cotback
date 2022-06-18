<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtractivoNatural extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 
        'direccion', 
        'estado', 
        'usuario_creacion', 
        'usuario_modificacion', 
        'id_municipio'
    ];

    public function UsuarioCreador() 
    {
        return $this->belongsTo(User::class, 'usuario_creacion');
    }

    public function UsuarioModificador() 
    {
        return $this->belongsTo(User::class, 'usuario_modificacion');
    }

    public function Municipio() 
    {
    	return $this->belongsTo(Municipio::class, 'id_municipio');
    }
}
