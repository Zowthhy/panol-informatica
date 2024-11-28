<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prestamo extends Model
{
    use HasFactory;

    protected $fillable = ['id_computadora', 'id_encargado', 'id_usuario', 'devolucion'];

public function computadora()
{
    return $this->belongsTo(computadora::class, 'id_computadora');
}

public function encargado()
{
    return $this->belongsTo(User::class, 'id_encargado');
}

public function usuario()
{
    return $this->belongsTo(Usuario::class, 'id_usuario');
}
public function reportes()
{
    return $this->hasMany(Reporte::class, 'id_prestamo'); 
}
}
