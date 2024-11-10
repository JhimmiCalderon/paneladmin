<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historialpersona extends Model
{
    use HasFactory;

    protected $fillable = ['persona_id', 'accion'];

    public function peersona()
    {
        return $this->belongsTo(Persona::class);
    }
}
