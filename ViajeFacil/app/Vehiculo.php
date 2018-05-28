<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $primaryKey = 'id_vehiculo';

    public $timestamps = false;

    protected $fillable = [
        'patente','marca','modelo','cantidad_asientos',
    ];
}
