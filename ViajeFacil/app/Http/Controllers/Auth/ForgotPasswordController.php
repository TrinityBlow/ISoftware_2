<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function customResetLink(Request $data){
        if(!is_null($data['nombre']) && !is_null($data['apellido']) && !is_null($data['email'])){
            $userReset = User::where('email','=',$data['email'])->first();
            if (!is_null($userReset) && ($userReset->name == $data['nombre']) && ($userReset->last_name == $data['apellido'])){
                $userReset->password = \Hash::make(1234);
                $userReset->update();
                return redirect('/login')->with('success','La contraseña fue reinicia a 1234');                
            }else{
                return redirect()->back()->with('message','Los datos no coinciden con los guardados');
            }
        }
    }
}
