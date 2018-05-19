<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Viaje;
use Auth;

class Viajes extends Controller
{
    public function __construct()
    {
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

    public function verDetallesViaje($id)
    {
        $viaje = Viaje::find($id);
        return view('viajes.verDetallesViaje')->with('viaje',$viaje);
    }
}
