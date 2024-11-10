<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proceso extends Model
{
    public function empresa()
{
    return $this->belongsTo(Admin::class, 'id_empresa');
}
  
    public function puesto()
    {
        return $this->belongsTo(Empleado::class, 'id');
    }
 
        public function personas()
    {
        return $this->belongsToMany(Persona::class, 'persona_proceso', 'proceso_id', 'persona_id')->withPivot('activar', 'estado')
        ->withTimestamps();
    }
       public function servicio()
    {
        return $this->belongsToMany(Servicio::class, 'servicios_procesos', 'servicio_id', 'proceso_id')
            ->withPivot('tipo')
            ->withTimestamps();
    }

    
    
    public function admin()
    {
        return $this->hasOne(Cajero::class, 'id');
    }
  
     
    
        use HasFactory;
       
        protected $fillable = ['id','id_empresa','proceso','contenido'];
    
       
    }

