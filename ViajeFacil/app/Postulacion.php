<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Postulacion extends Model
{
    protected $primaryKey = 'id_postulacion';

    protected $table = 'postulaciones';
    
    public $timestamps = false;

    protected $fillable = [
        'estado_postulacion',
        'calificacion_viajero',
        'calificacion_viaje',
        'comentario_viaje',
        'comentario_viajero',
        'id',
        'id_viaje',
    ];

    public function user()
    {
        return $this->hasOne('App\User','id','id');
    }
    
    public function viaje()
    {
        return $this->hasOne('App\Viaje','id_viaje','id_viaje');
    }

}
