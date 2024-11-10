<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    
   public function procesos()
   {
       return $this->belongsToMany(Procesos::class, 'servicios_procesos', 'servicio_id', 'proceso_id')
                   ->withPivot('tipo')
                   ->withTimestamps();
   }   
    use HasFactory;

    protected $fillable = ['id','id_empresa','name','contenido','tipo','id_procesos','precio'];
}
