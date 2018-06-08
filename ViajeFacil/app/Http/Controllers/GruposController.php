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
        // Verificacion necesaria en controller para que tenga permiso de usuario.
        $this->middleware('auth');  
    }

    protected function grupoTienePostulacion($mi_grupo){
        $postulacionesViajes = array();
        $relacionDelGrupo = GruposViaje::where('id_grupo','=',$mi_grupo->id_grupo)->get();
        $suma = 0;
        foreach($relacionDelGrupo as $relacion)
        {
            $suma = Postulacion::where('id_viaje','=',$relacion->id_viaje)->where('estado_postulacion','=','aceptado')->count() + $suma;
        }
        return $suma;
    }

    public function verDetallesGrupo($id_grupo)
    {
    	$user = Auth::user();
    	$mis_viajes=array();
        $registros = GruposViaje::all();

        foreach($registros as $registro)
        {
            if($registro['id_grupo'] == $id_grupo){
                $mis_viajes[] = Viaje::find($registro['id_viaje']);
            }
        }

        $usuario_creador = User::find(Grupo::find($id_grupo)->id);
        return view('viajes.verDetallesGrupo')
        ->with('usuario_creador',$usuario_creador)
        ->with('viajes',$mis_viajes);
    }

    public function modificarGrupo($id)
    {
        $viaje = Grupo::find($id);
        $suma = $this->grupoTienePostulacion($viaje);
        if($suma == 0){
            $hora = explode(' ',$viaje->fecha)[1];
            $vehiculos = parent::vehiculosUsuario();
            return view('viajes.modificarViaje')->with('viaje',$viaje)
            ->with('vehiculos',$vehiculos)
            ->with('hora',$hora);
        }else{
            return redirect("/viajes/misViajes")->with('error', 'El viaje ya tiene postulaciones aceptadas y no se puede modificar');
        }
    }

    public function modificarGrupoId(Request $data)
    {
        $mi_grupo = Grupo::find($data['id_grupo']);

        

        $suma = $this->grupoTienePostulacion($mi_grupo);

        if($suma == 0){
            $mi_grupo->titulo = $data->input('titulo');
            $mi_grupo->origen = $data->input('origen');
            $mi_grupo->destino = $data->input('destino');

            if (($mi_grupo->fecha != $data->fecha) || ($mi_grupo->tipo_viaje != $data->tipo_viaje)){
                $grupos_viaje = GruposViaje::where('id_grupo', '=', $data['id_grupo']);
                foreach ($grupos_viaje->get() as $dato)
                {
                    parent::eliminarViaje($dato->id_viaje);
                }
                $grupos_viaje->delete();
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

            return redirect("/viajes/misViajes")->with('mensaje', '¡El viaje ha sido modificado correctamente!');
        }else{
            return redirect("/viajes/misViajes")->with('error', 'El viaje ya tiene postulaciones aceptadas y no se puede modificar');
        }

    }

    public function eliminarGrupo(Request $data)
    {
        $id = $data->id_grupo;
        $grupo = Grupo::find($id);
        $grupos_viaje = GruposViaje::where('id_grupo', '=', $id);
        foreach ($grupos_viaje->get() as $dato)
        {
            parent::eliminarViaje($dato->id_viaje);
        }
        $grupo->delete();

        $grupos_viaje->delete();
        return redirect('/viajes/misViajes')->with('mensaje', '¡El viaje ha sido eliminado correctamente!');
    }

    public function verViajesDetalle($id_grupo){
    	$user = Auth::user();
    	$mis_viajes=array();
        $registros = GruposViaje::all();
        $today = Carbon::now();

        foreach($registros as $registro)
        {
            if($registro['id_grupo'] == $id_grupo){
                $mis_viajes[] = Viaje::find($registro['id_viaje']);
            }
        }

        $postulacionesViajes = array();
        $relacionDelGrupo = GruposViaje::where('id_grupo','=',$id_grupo)->get();
        foreach($relacionDelGrupo as $relacion)
        {
            $suma = 0;
            $suma = Postulacion::where('id_viaje','=',$relacion->id_viaje)->where('estado_postulacion','=','pendiente')->count() + $suma;
            $postulacionesViajes[$relacion->id_viaje] = $suma;
        }

        $usuario_creador = User::find(Grupo::find($id_grupo)->id);
        return view('viajes.verViajesDetalle')
        ->with('usuario_creador',$usuario_creador)
        ->with('mis_viajes',$mis_viajes)
        ->with('postulacionesViajes',$postulacionesViajes)
        ->with('today',$today);
    }
}
