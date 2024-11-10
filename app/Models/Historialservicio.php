<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historialservicio extends Model
{
    use HasFactory;

    protected $fillable = ['proceso_id', 'accion'];

    public function proceso()
    {
        return $this->belongsTo(Proceso::class);
    }

}
