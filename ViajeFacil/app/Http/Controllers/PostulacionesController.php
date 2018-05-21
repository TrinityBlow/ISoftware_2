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
        $postulacionBorrar = Postulacion::where('id','=',$user->id)->where('id_viaje','=',$id);
        if($postulacionBorrar->get()->count()){
            $postulacionBorrar->delete();
        }
        return redirect('/viajes/verDetallesViaje/'.$id);

    }
    

}
