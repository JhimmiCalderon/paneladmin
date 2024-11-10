<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Proceso;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;
use Illuminate\Notifications\Notifiable; // Asegúrate de que "Notifiable" esté escrito con "N" mayúscula


class Empleado extends AuthenticatableUser implements Authenticatable
{
    public function historiales()
    {
        return $this->hasMany(HistorialEmpleado::class, 'empleado_id');
    }
    public function admin()
    {
        return $this->hasOne(Cajero::class, 'id_empresa');
    }
  
  
  
public function puesto()
{
    return $this->belongsTo(Proceso::class, 'puesto');
}

public function proceso()
{
    return $this->belongsTo(Proceso::class, 'puesto','id'); // Ajusta el nombre del campo si es diferente
}



    protected $guard_name = 'empleado';
   
    use HasFactory, Notifiable;


    protected $fillable = ['name', 'email' ,
    'id_empresa','password','lastname' ,'puesto', 'estado', 'imagen','cambio_contraseña'];

    

    protected $table = 'empleados';
}