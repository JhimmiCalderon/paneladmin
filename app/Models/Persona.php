<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;
use Illuminate\Notifications\Notifiable; // Asegúrate de que "Notifiable" esté escrito con "N" mayúscula


class Persona extends AuthenticatableUser implements Authenticatable 
{
    protected $guard_name = 'web';
  
   
   use HasFactory, Notifiable;

   public function procesos()
   {
       return $this->belongsToMany(Proceso::class, 'persona_proceso', 'persona_id', 'proceso_id')
                   ->withPivot('activar', 'estado')
                   ->withTimestamps();
   }    
   
   
 // En tu modelo Persona
 
 public function servicio()
 {
     return $this->belongsToMany(Servicio::class, 'servicios_procesos', 'servicio_id', 'proceso_id')
         ->withPivot('tipo')
         ->withTimestamps();
 }
 
public function puesto()
{
    return $this->belongsTo(Proceso::class, 'proceso');
}
 

public function empleados()
{
    return $this->hasMany(Empleado::class, 'id');
}
    
   public function admin()
   {
    return $this->hasOne(Cajero::class, 'id_empresa');
   }
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'observacion',
        'id_empresa',
        'numero_celular',
        'id_procesos',
        'entregar',
        'relaciones_completas',
         'contador',

    ];
    

    protected $table = 'personas';
}