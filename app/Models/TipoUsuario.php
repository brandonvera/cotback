<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function Usuarios () {
    	return $this->hasMany(User::class, 'id');
    }
}
