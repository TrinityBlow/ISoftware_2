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
                'calificacion_viajero' => 0,
                'id' => $user->id,
                'id_viaje' => $id,
            ]);
        }
        return redirect('/viajes/verDetallesViaje/'.$id);
    }

    public function cancelarPostulacion($id){
        
        $user = Auth::user(); 
        $postulacionBorrar = Postulacion::where('id','=',$user->id)->where('id_viaje','=',$id)->firstOrFail();
        if($postulacionBorrar->count()){
            if($postulacionBorrar->estado_postulacion == 'pendiente'){
                $postulacionBorrar->delete();
            }
        }
        return redirect('/viajes/verDetallesViaje/'.$id);

    }

    public function rechazarPostulacionViajante($id){
        
        $user = Auth::user(); 
        $postulacionBorrar = Postulacion::where('id','=',$user->id)->where('id_viaje','=',$id)->firstOrFail();
        if($postulacionBorrar->count()){
            if($postulacionBorrar->estado_postulacion == 'aceptado'){
                //codigo de bajar reputacion
                $postulacionBorrar->delete();
            }
        }
        return redirect('/viajes/verDetallesViaje/'.$id);

    }
    
    public function verPostulaciones($id){
        
        $user = Auth::user(); 
        $postulacionesDelViaje = Postulacion::where('id','!=',$user->id)->where('id_viaje','=',$id);
        return view('postulaciones.verPostulaciones')->with('postulaciones',$postulacionesDelViaje->get());

    }

    public function manejarPostulacion(Request $data){
        
        $user = Auth::user(); 
        $id_viaje = Postulacion::find($data->id_postulacion)->id_viaje;
        if($data->action == 'aceptar'){
            $postulacionUpdate = Postulacion::where('id','=',$data->postulado_id)->where('id_viaje','=',$id_viaje)->first();
            if($postulacionUpdate->count()){
                $postulacionUpdate->estado_postulacion = 'aceptado';
                $postulacionUpdate->save();
            }
        }elseif($data->action == 'rechazar'){
            $postulacionUpdate = Postulacion::where('id','=',$data->postulado_id)->where('id_viaje','=',$id_viaje)->first();
            if($postulacionUpdate->count()){
                $postulacionUpdate->estado_postulacion = 'rechazado';
                $postulacionUpdate->save();
            }
        }
        return redirect('/viajes/verPostulacionesViaje/'.$id_viaje);

    }



}
