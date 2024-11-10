<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;




class Cajero extends AuthenticatableUser implements Authenticatable
{
  
    public function personas()
    {
        return $this->belongsToMany(Persona::class, 'persona_proceso', 'proceso_id', 'persona_id')
                    ->withPivot('completo', 'estado')
                    ->withTimestamps();
    }
    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'puesto');
    }
    


    protected $guard_name = 'cajero';
   
    use HasFactory, Notifiable;


    protected $fillable = ['name', 'email' ,
    'id_empresa','password','lastname' , 'estado', 'imagen','cambio_contraseña'];

    

    protected $table = 'cajeros';
}
