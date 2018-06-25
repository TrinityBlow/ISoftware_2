<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;

class ContactoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function contacto()
    {
        return view('contacto');
    }

    public function enviarMensaje()
    {
        return redirect()->back()->with('mensajeSuccess', '¡El mensaje ha sido enviado correctamente!');
    }
}
