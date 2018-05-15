<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;

class MiUsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  
    }



    public function index()
    {
        return view('usuarios.mi_usuario');
    }

    protected function modificar(Request $request)
    {
    
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
 
        /*

            if ( ! Request::input('password') == '')
            {
                $user->password = bcrypt(Request::input('password'));
            }

        */

        $user->save();
        return redirect('mi_usuario');
    }
    
}
