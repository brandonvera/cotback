<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representante extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'persona', 
        'cargo', 
        'telefono', 
        'correo', 
        'direccion', 
        'estado', 
        'usuario_creacion', 
        'usuario_modificacion'
    ];

    public function UsuarioCreador() 
    {
        return $this->belongsTo(User::class, 'usuario_creacion');
    }

    public function UsuarioModificador() 
    {
        return $this->belongsTo(User::class, 'usuario_modificacion');
    }

    public function Hospedaje() 
    {
    	return $this->hasMany(Hospedaje::class, 'id_representantes');
    }

    public function Alimento() 
    {
    	return $this->hasMany(Alimento::class, 'id_representantes');
    }

    public function Recreacion() 
    {
    	return $this->hasMany(Recreacion::class, 'id_representantes');
    }

    public function Transporte() 
    {
    	return $this->hasMany(Transporte::class, 'id_representantes');
    }
}
