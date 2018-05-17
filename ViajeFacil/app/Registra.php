<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registra extends Model
{
    protected $table = 'registra';

    public $timestamps = false;

    protected $fillable = [
        'id','id_vehiculo',
    ];
}
