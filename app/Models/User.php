<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasFactory;

    protected $guarded = [];

    // protected $fillable = ['nombre', 'apellido', 'email', 'password', 'estado', 'usuario_creacion', 'usuario_modificacion', 'id_tipo'];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    // public function tieneUsuarios()
    // {
    //     return $this->hasMany(User::class);
    // }
    
    public function TipoUsuario() {
        return $this->belongsTo(TipoUsuario::class, 'id_tipo');
    }

    public function UsuarioCreador() {
        return $this->belongsTo(User::class, 'usuario_creacion');
    }

    public function UsuarioModificador() {
        return $this->belongsTo(User::class, 'usuario_modificacion');
    }

    public function TieneMunicipio() {
        return $this->hasMany(Municipio::class);
    }

    public function TieneRepresentante() {
        return $this->hasMany(Representante::class);
    }

    public function TieneHospedaje() {
        return $this->hasMany(Hospedaje::class);
    }

    public function TieneRecreacion() {
        return $this->hasMany(Recreacion::class);
    }

    public function TieneAlimento() {
        return $this->hasMany(Alimento::class);
    }

    public function TieneTransporte() {
        return $this->hasMany(Transporte::class);
    }

    public function TieneAtractivoCultural() {
        return $this->hasMany(AtractivoCultural::class);
    }

    public function TieneAtractivoNatural() {
        return $this->hasMany(AtractivoNatural::class);
    }
}
