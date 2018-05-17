<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;

class Viajes extends Controller
{
    public function __construct()
    {

        // verificacion necesaria en controller para que tenga permiso de usuario
        $this->middleware('auth');  
    }

    public function buscarViajes()
    {
        return view('viajes.buscarViajes');
    }


        
    public function crearViaje()
    {
        return view('viajes.crearViaje');
    }

}
