<?php

namespace App\Http\Controllers;

use App\User;
use App\Vehiculo;
use App\Registra;
use App\Viaje;
use Illuminate\Support\Carbon;
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
   
    public function crearViaje()
    {
        $vehiculos = $this->vehiculosUsuario();
        if(!count($vehiculos)){
            return redirect('/');
        }
        return view('viajes.crearViaje')->with('vehiculos',$vehiculos);
    }

    public function verDetallesViaje($id)
    {
        $viaje = Viaje::find($id);
        $usuario_creador = User::find($viaje['id']);
        return view('viajes.verDetallesViaje')
        ->with('usuario_creador',$usuario_creador)
        ->with('viaje',$viaje);
    }

    public function buscarViajes(Request $data)
    {

        /* Carbon es un paquete de Laravel que permite hacer todo tipo de operaciones con fechas */     
        $f0 = Carbon::today();

        $f1 = Carbon::today();

        $f1 -> addDays(30);

        if (!empty($data)){
            $viajes = Viaje::whereBetween('fecha', [$f0, $f1])->get();
        } elseif ((!empty($data['ori'])) and (empty($data['dest']))) {
            $filtroOrigen = $data['ori'];
            $viajes = Viaje::whereBetween('fecha', [$f0, $f1])->get()->where('origen','like','%'.$filtroOrigen.'%');
        } elseif (empty($data['ori'])) {
            $filtroDestino = $data['dest'];
            $viajes = Viaje::whereBetween('fecha', [$f0, $f1])->get()->where('dest','like','%'.$filtroDestino.'%');
        } else {
           $filtroOrigen = $data['ori'];
           $filtroDestino = $data['dest'];
           $viajes = Viaje::whereBetween('fecha', [$f0, $f1])->get()->where('origen','like','%'.$filtroOrigen.'%')->where('dest','like','%'.$filtroDestino.'%');
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
}
