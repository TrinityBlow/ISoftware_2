<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    protected $primaryKey = 'id_configuracion';

    protected $table = 'configuracion';

    public $timestamps = false;

    protected $fillable = [
        'fondo',
    ];
}
