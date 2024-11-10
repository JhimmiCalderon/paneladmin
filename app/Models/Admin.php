<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;


use Illuminate\Notifications\Notifiable;


class Admin extends AuthenticatableUser implements Authenticatable
{
    use HasFactory, Notifiable;


    
    public function personas()
    {
        return $this->hasMany(Persona::class,'id_empresa');
    }
    public function cajero()
    {
        return $this->hasOne(Cajero::class, 'id_empresa');
    }

    public function empleados()
    {
        return $this->hasOne(Cajero::class, 'id_empresa');
    }

    public function proceso()
    {
        return $this->hasOne(Cajero::class, 'id_empresa');
    }
    public function servicio()
    {
        return $this->hasOne(Servicio::class, 'id_empresa');
    }
    protected $guard_name = 'admin';

  
    
    protected $fillable = [
        'name',
        'email',
        'imagen',
        'direccion',
        'nit',
        'password',
        'estado',
        'cambio_contraseña',
        
    ];

    protected $table = 'admins';
}
