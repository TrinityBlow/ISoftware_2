<?php

namespace App\Http\Controllers;

use App\User;
use App\Vehiculo;
use App\Registra;
use App\Grupo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
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

    public function validation ()
    {

    }

    public function index()
    {
        $mis_vehiculos= array();
        $registros = Registra::all();
        $user = Auth::user();

        foreach($registros as $registro)
        {
            if($registro['id'] == $user['id']){
                $mis_vehiculos[] = Vehiculo::find($registro['id_vehiculo']);
            }
        }

        return view('usuarios.mi_usuario')->with('mis_vehiculos', $mis_vehiculos)->with('user', $user);
    }

    public function agregarVehiculo()
    {
        return view('usuarios.agregarVehiculo');
    }

    private function validateModification($data)
    {
        if (Auth::user()->email == $data['email']){
            $data->validate([
                'name' => 'required|string|min:1|max:255',
                'last_name' => 'required|string|min:1|max:255',
                'birthdate' => 'required|date',
                'image' => 'image|nullable|max:1999',
            ]);
        } else {
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

        if ($request->hasFile('image')){
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('image')->storeAs('public/images',$fileNameToStore);
            $user->image = $fileNameToStore;
        }

        $user->name = $request->input('name');
        $user->last_name = $request->input('last_name');
        $user->birthdate = $request->input('birthdate');
        $user->email = $request->input('email');

        /*
            if ( ! Request::input('password') == ''){
                $user->password = bcrypt(Request::input('password'));
            }
        */

        $user->save();
        return redirect('/mi_usuario')->with('mensajeSuccess','¡Los datos han sido modificados correctamente!');
    }

    public function imagenUsuario($id)
    {
        $user = Auth::user();
        header("Content-type: image/jpg");
        echo $user->image;
    }

    public function verPassword()
    {
        $user = Auth::user();
        return view('usuarios.verPassword')->with('user', $user);
    }   

    protected function validator($data)
    {
        $data->validate([
            'password' => 'required|string|min:4|confirmed',
        ]);
    }

    public function cambiarPassword(Request $data)
    {
        $this->validator($data);
        $user = Auth::user();
        $user->password = Hash::make($data['password']);
        $user->update();
        return redirect('/mi_usuario')->with('mensajeSuccess','¡La contraseña ha sido modificada correctamente!');
    }

    public function eliminarUsuario()
    {
        $user = Auth::user();
        $mis_grupos = Grupo::where('id','=',$user->id)->get();
        $grupoControl = new GruposController; 
        foreach ($mis_grupos as $grupo) {
            $data = new Request;
            $data['id_grupo'] = $grupo->id_grupo;
            $grupoControl->eliminarGrupo($data);
          //  GruposController::eliminarMiGrupoStatic($grupo->id_grupo);
        }
        $mis_vehiculos = Registra::where('id','=',$user->id)->get();
        foreach ($mis_vehiculos as $vehiculo) {
            DB::table('registra')->where('id_vehiculo', '=', $vehiculo->id_vehiculo)->delete();
            DB::table('vehiculos')->where('id_vehiculo', '=', $vehiculo->id_vehiculo)->delete();
        }
        $user->delete();
        return redirect('/')->with('mensajeSuccess','Usted se ha dado de baja del sistema satisfactoriamente. Lamentamos su pérdida. Antes reclamos y críticas: facundolopezosornio@viajefacil.com');
    }
    
    /*
    public function showPicture($id)
    {
        $picture = User::find($id);
        $pic = Image::make($picture->image);
        $response = Response::make($pic->encode('jpg'));

        //setting content-type
        $response->header('Content-Type', 'image/jpg');

        return $response;
    }
    */
}
