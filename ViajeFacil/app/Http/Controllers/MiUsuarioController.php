<?php

namespace App\Http\Controllers;

use App\User;
use App\Vehiculo;
use App\Registra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Response;
use Auth;


class MiUsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  
    }

    public function validation (){

    }

    public function index()
    {
        $mis_vehiculos= array();
        $registros = Registra::all();
        $user = Auth::user();

        foreach($registros as $registro){
            if($registro['id'] == $user['id']){
                $mis_vehiculos[] = Vehiculo::find($registro['id_vehiculo']);
            }
        }
        return view('usuarios.mi_usuario')->with('mis_vehiculos', $mis_vehiculos);
    }

    public function agregarVehiculo()
    {
        return view('usuarios.agregarVehiculo');
    }

    private function validateModification($data){
        if (Auth::user()->email == $data['email']){
            $data->validate([
                'name' => 'required|string|min:1|max:255',
                'last_name' => 'required|string|min:1|max:255',
                'birthdate' => 'required|date',
                'image' => 'image|nullable|max:1999',
            ]);
        }else{
            $data->validate([
                'name' => 'required|string|min:1|max:255',
                'last_name' => 'required|string|min:1|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'birthdate' => 'required|date',
                'image' => 'image|nullable|max:1999',
            ]);
        }
    }

    protected function modificar(Request $request)
    {
        $this->validateModification($request);
        $user = Auth::user();

		if($request->hasFile('image')){
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('image')->storeAs('public/images',$fileNameToStore);
            $user->image = $fileNameToStore;
        }

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

    public function imagenUsuario($id){
        $user = Auth::user();
        header("Content-type: image/jpg"); 
        echo $user->image; 
        
    }
    
}
