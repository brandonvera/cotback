<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
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
    	return $this->hasMany(Hospedaje::class, 'id_municipio');
    }

    public function Alimento() 
    {
    	return $this->hasMany(Alimento::class, 'id_municipio');
    }

    public function Recreacion() 
    {
    	return $this->hasMany(Recreacion::class, 'id_municipio');
    }

    public function Transporte() 
    {
    	return $this->hasMany(Transporte::class, 'id_municipio');
    }

    public function AtractivoCultural() 
    {
    	return $this->hasMany(AtractivoCultural::class, 'id_municipio');
    }

    public function AtractivoNatural() 
    {
    	return $this->hasMany(AtractivoNatural::class, 'id_municipio');
    }
}
