<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $primaryKey = 'id_grupo';

    protected $table = 'grupos';

    public $timestamps = false;

    protected $fillable = [
        'origen',
        'destino',
        'fecha',
        'precio',
        'tipo_viaje',
        'titulo',
        'id_vehiculo',
        'id',
    ];
    
}
