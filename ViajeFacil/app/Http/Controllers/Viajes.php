<?php

namespace App\Http\Controllers;

use App\User;
use App\Vehiculo;
use App\Registra;
use App\Viaje;
use App\Postulacion;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Auth;

class Viajes extends Controller
{
    public function __construct()
    {

        // verificacion necesaria en controller para que tenga permiso de usuario
        $this->middleware('auth');  
    }
   
    public function crearViaje()
    {        
        $f0 = Carbon::today();

        $f1 = Carbon::today();

        $f1 -> addDays(30);

        $vehiculos = $this->vehiculosUsuario();
        if(!count($vehiculos)){
            return redirect('/');
        }
        return view('viajes.crearViaje')->with('vehiculos',$vehiculos)
        ->with('f0',$f0)
        ->with('f1',$f1);
    }

    public function verDetallesViaje($id)
    {
        $user = Auth::user();
        $viaje = Viaje::find($id);
        $usuario_creador = User::find($viaje['id']);
        $tiene_postulacion = Postulacion::where('id','=',$user->id)->where('id_viaje','=',$viaje->id_viaje)->get();
        return view('viajes.verDetallesViaje')
        ->with('usuario_creador',$usuario_creador)
        ->with('viaje',$viaje)
        ->with('postulacion',$tiene_postulacion);
    }

    public function buscarViajes(Request $data)
    {

        /* Carbon es un paquete de Laravel que permite hacer todo tipo de operaciones con fechas */ 
        
        $f0 = Carbon::today();

        $f1 = Carbon::today();

        $f1 -> addDays(30);


        if ((!is_null($data['ori'])) and (is_null($data['dest']))) {
            $filtroOrigen = '%' . $data['ori'] . '%';
            $viajes = Viaje::whereBetween('fecha', [$f0, $f1])->where('origen','like',$filtroOrigen)->get();
        } elseif ((is_null($data['ori'])) and (!is_null($data['dest']))) {
            $filtroDestino = $data['dest'];
            $viajes = Viaje::whereBetween('fecha', [$f0, $f1])->where('destino','like','%'.$filtroDestino.'%')->get();
        } elseif ((!is_null($data['ori'])) and (!is_null($data['dest']))) {
           $filtroOrigen = $data['ori'];
           $filtroDestino = $data['dest'];
           $viajes = Viaje::whereBetween('fecha', [$f0, $f1])->where('origen','like','%'.$filtroOrigen.'%')->where('destino','like','%'.$filtroDestino.'%')->get();
        } else {
           $viajes = Viaje::whereBetween('fecha', [$f0, $f1])->get();
        }

        return view('viajes.buscarViajes') -> with('viajes', $viajes);
    }

    private function validateViaje($data){
        $data->validate([
            'origen' => 'required|string|min:1|max:255',
            'destino' => 'required|string|min:1|max:255',
            'precio' => 'required',
        ]);
    }    

    public function publicarViaje(Request $data){
        $this->validateViaje($data);

        $user = Auth::user();
        $date = date_create($data['fecha'] . $data['hora']);
        $nuevo_viaje = Viaje::create([
            'origen' => $data['origen'],
            'destino' => $data['destino'],
            'fecha' => date_format($date,'Y-m-d H:i'),
            'precio' => $data['precio'],
            'tipo_viaje' => $data['tipo_viaje'],
            'id_vehiculo' => $data['id_vehiculo'],
            'id' => $user['id'],
            ]);

        return redirect('mi_usuario')->with('mensajeCrearViaje', 'El viaje ha sido publicado correctamente.');
    }

    private function vehiculosUsuario()
    {
        $user = Auth::user();
        $registras = Registra::all();
        $mis_vehiculos = array();
        foreach ($registras as $registra){
            if($registra['id'] == $user['id']){
                $mis_vehiculos[] = Vehiculo::find($registra['id_vehiculo']);
            }
        }
        return $mis_vehiculos;
    }


    public function misViajes(){
        $user = Auth::user();
        $mis_viajes = Viaje::where('id','like',$user['id'])->get();
        return view('viajes.misViajes') -> with('mis_viajes', $mis_viajes);
    }

    public function modificarViaje($id)
    {
        //
        $viaje = Viaje::find($id);
        return view('viajes.modificarViaje')->with('viaje',$viaje);
    }

    public function modificarViajeId(Request $data)
    {
        //
        $mi_viaje = Viaje::find($data['id_viaje']);

        $mi_viaje->origen = $data->input('origen');
        $mi_viaje->destino = $data->input('destino');
        $mi_viaje->fecha = $data->input('fecha');
        $mi_viaje->precio = $data->input('precio');
        $mi_viaje->tipo_viaje = $data->input('tipo_viaje');        

        $mi_viaje->save();

        return redirect("/viajes/modificarViaje/" . $mi_viaje->id_viaje);
    }

    public function eliminarViaje($id)
    {
        //
        $mi_viaje = Viaje::find($id);
        DB::table('viajes')->where('id_viaje', '=', $mi_viaje->id_viaje)->delete();
        return redirect('/mi_usuario');
    }


}
