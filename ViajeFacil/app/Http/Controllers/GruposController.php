<?php

namespace App\Http\Controllers;

use App\User;
use App\Vehiculo;
use App\Registra;
use App\Viaje;
use App\Postulacion;
use App\Grupo;
use App\GruposViaje;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Auth;

class GruposController extends Viajes 
{
    public function __construct()
    {

        // verificacion necesaria en controller para que tenga permiso de usuario
        $this->middleware('auth');  
    }

    public function verDetallesGrupo($id_grupo){
    	$user = Auth::user();
    	$mis_viajes=array();
        $registros = GruposViaje::all();


        foreach($registros as $registro){
            if($registro['id_grupo'] == $id_grupo){
                $mis_viajes[] = Viaje::find($registro['id_viaje']);
            }
        }

        $usuario_creador = User::find(Grupo::find($id_grupo)->id);
        return view('viajes.verDetallesGrupo')
        ->with('usuario_creador',$usuario_creador)
        ->with('viajes',$mis_viajes);
    }

    public function modificarGrupoId(Request $data)
    {
        //
        $mi_grupo = Grupo::find($data['id_grupo']);
        /* FALTA EL TITULO */
        $mi_grupo->origen = $data->input('origen');
        $mi_grupo->destino = $data->input('destino');

        if (($mi_grupo->fecha != $data->fecha) || ($mi_grupo->tipo_viaje != $data->tipo_viaje)) {
            parent::createViajes($data);
        }

        $date = explode('-',$data->fecha);
        $carbonDate = Carbon::createFromDate($date[0],$date[1],$date[2]);
        $carbonDate->setTimeFromTimeString($data->hora);
        $date = date_create($carbonDate);
        $mi_grupo->fecha = $date;

        $mi_grupo->precio = $data->input('precio');
        $mi_grupo->tipo_viaje = $data->input('tipo_viaje');        

        $mi_grupo->save();

        return redirect("/viajes/misViajes/");
    }

}