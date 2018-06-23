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
use Auth;

class PostulacionesController extends Controller
{    
    
    public function __construct()
    {
        $this->middleware('auth');  
    }
    
    public function postularmeViaje($id)
    {
        $user = Auth::user(); 
        if(!Postulacion::where('id','=',$user->id)->where('id_viaje','=',$id)->get()->count()){
            $nueva_postulacion = Postulacion::create([
                'estado_postulacion' => 'pendiente',
                'calificacion_viajero' => null,
                'calificacion_viaje' => null,
                'id' => $user->id,
                'id_viaje' => $id,
            ]);
        }
        return redirect('/viajes/verDetallesViaje/'.$id);
    }

    public function cancelarPostulacion($id)
    {
        $user = Auth::user(); 
        $postulacionBorrar = Postulacion::where('id','=',$user->id)->where('id_viaje','=',$id)->firstOrFail();
        if($postulacionBorrar->count()){
            if($postulacionBorrar->estado_postulacion == 'pendiente'){
                $postulacionBorrar->delete();
            }
        }
        // return redirect('/viajes/verDetallesViaje/'.$id);
        return redirect()->back()->with('mensajeSuccess', '¡La postulación ha sido cancelada correctamente!');
    }

    public function rechazarPostulacionViajante(Request $data)
    {
        $user = Auth::user(); 
        $postulacionBorrar = Postulacion::where('id','=',$user->id)->where('id_viaje','=',$data->id_viaje)->firstOrFail();
        if($postulacionBorrar->count()){
            if($postulacionBorrar->estado_postulacion == 'aceptado'){
                // Codigo de bajar reputacion.
                $postulacionBorrar->delete();
            }
        }
        // return redirect('/viajes/verDetallesViaje/'.$data->id_viaje);
        return redirect()->back()->with('mensajeSuccess', '¡La postulación ha sido rechazada correctamente!');
    }

    public function verPostulaciones($id)
    {
        $user = Auth::user(); 
        $postulacionesDelViaje = Postulacion::where('id','!=',$user->id)->where('id_viaje','=',$id);
        return view('postulaciones.verPostulaciones')->with('postulaciones',$postulacionesDelViaje->get());
    }

    private function hayLugar($id_viaje)
    {
        $vehiculo = Vehiculo::find(Viaje::find($id_viaje)->id_vehiculo);
        $postulaciones_aceptadas = Postulacion::where('id_viaje','=',$id_viaje)->where('estado_postulacion','=','aceptado');
        if($postulaciones_aceptadas->count() < ($vehiculo->cantidad_asientos - 1)){
            return true;
        }
        return false;
    }

    public function manejarPostulacion(Request $data)
    {
        $user = Auth::user(); 
        $id_viaje = Postulacion::find($data->id_postulacion)->id_viaje;
        if ($data->action == 'aceptar'){
            if ($this->hayLugar($id_viaje)){
                $postulacionUpdate = Postulacion::where('id','=',$data->postulado_id)->where('id_viaje','=',$id_viaje)->first();
                if($postulacionUpdate->count()){
                    $postulacionUpdate->estado_postulacion = 'aceptado';
                    $postulacionUpdate->save();
                }
            } else {
                return redirect()->back()->with('mensajeDanger','¡No hay más asientos disponibles en el viaje!');
            }
        } elseif ($data->action == 'rechazar') {
            $postulacionUpdate = Postulacion::where('id','=',$data->postulado_id)->where('id_viaje','=',$id_viaje)->first();
            if($postulacionUpdate->count()){
                $postulacionUpdate->estado_postulacion = 'rechazado';
                $postulacionUpdate->save();
            }
        }
        return redirect()->back();
    }

    public function misPostulaciones()
    {
        $user = Auth::user();
        $postulaciones = Postulacion::where('id','=',$user->id)->get();
        if ($postulaciones != '[]') {
            foreach ($postulaciones as $postulacion) {
                $viaje = Viaje::find($postulacion->id_viaje);
                $vehiculo = Vehiculo::find($viaje->id_vehiculo);
                $viaje['precio'] = $viaje->precio / $vehiculo->cantidad_asientos;
                $postulacion->id_viaje = $viaje;
            }
            return view('postulaciones.misPostulaciones')->with('postulaciones',$postulaciones);
        } else {
            return redirect('/home')->with('info', 'sinPostulaciones');
        }
    }

    public function calificarViaje(Request $data)
    {
        $user = Auth::user(); 
        $postulacion = Postulacion::where('id','=',$user->id)->where('id_viaje','=',$data->id_viaje)->firstOrFail();
        if($postulacion->count()){
            if($postulacion->estado_postulacion == 'aceptado'){
                // Codigo de reputacion.
                $postulacion->calificacion_viaje = $data->calificacion;
                $postulacion->save();
            }
        }
        return redirect()->back()->with('mensajeSuccess', '¡La calificación ha sido registrada correctamente!');
    }

    public function calificarViajero(Request $data)
    {
        $postulacion = Postulacion::where('id','=',$data->id)->where('id_viaje','=',$data->id_viaje)->firstOrFail();
        if($postulacion->count()){
            if($postulacion->estado_postulacion == 'aceptado'){
                // Codigo de reputacion.
                $postulacion->calificacion_viajero = $data->calificacion;
                $postulacion->save();
            }
        }
        return redirect()->back()->with('mensajeSuccess', '¡La calificación ha sido registrada correctamente!');
    }

    public function verViajeros($id)
    {
        $user = Auth::user(); 
        $viajeros = Postulacion::where('id','!=',$user->id)->where('id_viaje','=',$id)->where('estado_postulacion','=','aceptado');
        return view('postulaciones.calificarViajeros')->with('viajeros',$viajeros->get());
    }
}
