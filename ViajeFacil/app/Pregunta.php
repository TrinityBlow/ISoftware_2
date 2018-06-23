<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $primaryKey = 'id_pregunta';

    protected $table = 'pregunta';

    public $timestamps = false;

    protected $fillable = [
        'consigna',
        'respuesta',
        'id_viaje',
        'id',
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
