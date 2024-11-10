<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historialcajero extends Model
{
    protected $fillable = ['cajero_id', 'accion'];

    public function cajero()
    {
        return $this->belongsTo(Cajero::class);
    }
}
