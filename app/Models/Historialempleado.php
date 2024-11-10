<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historialempleado extends Model
{
    use HasFactory;

    protected $fillable = ['empleado_id', 'accion'];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}
