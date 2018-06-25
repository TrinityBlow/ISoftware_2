<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;

class AyudaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function ayuda()
    {
        return view('ayuda');
    }
}
