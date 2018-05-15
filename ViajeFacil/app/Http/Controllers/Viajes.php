<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Viajes extends Controller
{
    public function buscarViajes()
    {
        return view('viajes.buscarViajes');
    }

}
