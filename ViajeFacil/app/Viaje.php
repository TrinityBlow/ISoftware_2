<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Viaje extends Model
{

    protected $primaryKey = 'id_viaje';

    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'origen',
        'destino',
        'fecha',
        'precio',
        'tipo_viaje',
        'estado_viaje',
        'id_vehiculo',
        'id',
    ];

    public function user()
    {
        return $this->hasOne('App\User','id','id');
    }
}
