<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GruposViaje extends Model
{
    protected $table = 'grupos_viaje';

    public $timestamps = false;

    protected $fillable = [
        'id_viaje',
        'id_grupo',
    ];


}
