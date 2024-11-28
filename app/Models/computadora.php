<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class computadora extends Model
{
    use HasFactory;
    protected $fillable = ['estado', 'codigo_barras', 'disponible'];
}
