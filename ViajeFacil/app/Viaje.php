<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viaje extends Model
{
    //
    protected $primaryKey = 'id_viaje';

    public $timestamps = false;

    protected $fillable = [
        'origen',
        'destino',
        'fecha',
        'precio',
        'tipo_viaje',
        'id_vehiculo',
        'id',
    ];
}
