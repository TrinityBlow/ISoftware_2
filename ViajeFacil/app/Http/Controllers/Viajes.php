<?php

namespace App\Http\Controllers;

use App\User;
use App\Vehiculo;
use App\Registra;
use App\Viaje;
use App\Postulacion;
use App\Grupo;
use App\GruposViaje;
use App\Configuracion;
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
        // Verificacion necesaria en controller para que tenga permiso de usuario.
        $this->middleware('auth');  
    }
   
    public function crearViaje()
    {        
        $f0 = Carbon::today();

        $f1 = Carbon::today();

        $f1 -> addDays(30);

        $vehiculos = $this->vehiculosUsuario();
        if(!count($vehiculos)){
            return redirect('/home')->with('info', 'sinVehiculos');
        }
        return view('viajes.crearViaje')->with('vehiculos',$vehiculos)
        ->with('f0',$f0)
        ->with('f1',$f1);
    }

    public function verDetallesViaje($id)
    {
        $user = Auth::user();
        $viaje = Viaje::find($id);
        $vehiculo = Vehiculo::find($viaje->id_vehiculo);
        $viaje['precio'] = $viaje->precio / $vehiculo->cantidad_asientos;
        $usuario_creador = User::find($viaje['id']);
        $tiene_postulacion = Postulacion::where('id','=',$user->id)->where('id_viaje','=',$viaje->id_viaje)->first();
        return view('viajes.verDetallesViaje')
        ->with('usuario_creador',$usuario_creador)
        ->with('viaje',$viaje)
        ->with('vehiculo',$vehiculo)
        ->with('postulacion',$tiene_postulacion);
    }

    public function buscarViajes(Request $data)
    {
        /* Carbon es un paquete de Laravel que permite hacer todo tipo de operaciones con fechas */ 
        
        $f0 = Carbon::today();

        $f1 = Carbon::today();

        $f1 -> addDays(30);

        $viajes = (new Grupo)->newQuery();

        if ($data->has('ori')){
            $viajes->where('origen','like', '%'.$data['ori'].'%');
        }
        if ($data->has('dest')){
            $viajes->where('destino','like', '%'.$data['dest'].'%');
        }

        /* SI UTILIZO SOLAMENTE ORIGEN Y DESTINO ANDA, CON LOS DEMAS FILTROS NO */

        if (!is_null($data->precio)){
            $viajes->where('precio','<=', $data['precio']);
        }
        if (!is_null($data->fecha1)){
            $viajes->whereBetween('fecha', [$data['fecha1'], $f1]);
        }
        if (!is_null($data->fecha2)){
            $viajes->whereBetween('fecha', [$f0, $data['fecha2']]);
        } elseif ((is_null($data['fecha1'])) and (is_null($data['fecha2']))) {
            $viajes->whereBetween('fecha', [$f0, $f1]);            
        }
        $viajes = $viajes->orderBy('fecha', 'asc')->get();
        foreach ($viajes as $viaje)
        {
            $vehiculo = Vehiculo::find($viaje->id_vehiculo);
            $viaje['precio'] = $viaje->precio / $vehiculo->cantidad_asientos;
        }
        return view('viajes.buscarViajes') -> with('viajes', $viajes);
    }

    private function validateViaje($data)
    {
        $data->validate([
            'titulo' => 'required|string|min:1|max:255',
            'origen' => 'required|string|min:1|max:255',
            'destino' => 'required|string|min:1|max:255',
            'precio' => 'required',
            'titulo' => 'required',
        ]);
    }    

    protected function createViajes(Request $data)
    {
        $user = Auth::user();
        $grupo = Grupo::find($data->id_grupo);
        $data->precio = $data->precio * 1.1;
        if($data->tipo_viaje == 'ocasional'){
            $nuevo_viaje = Viaje::create([
                'titulo' => $data['titulo'],
                'origen' => $data['origen'],
                'destino' => $data['destino'],
                'fecha' => date_create($data['fecha'] . $data['hora']),
                'precio' => $data['precio'],
                'tipo_viaje' => $data['tipo_viaje'],
                'id_vehiculo' => $data['id_vehiculo'],
                'id' => $user['id'],
            ]);
            $grupoViaje = GruposViaje::create([
                'id_grupo' => $grupo->id_grupo,
                'id_viaje' => $nuevo_viaje->id_viaje,
            ]);
        } else {
            if ($data->tipo_viaje == 'diario'){
                $dias = 1;
            } else {
                $dias = 7;
            }
            $date = explode('-',$data->fecha);
            $carbonDate = Carbon::createFromDate($date[0],$date[1],$date[2]);
            $carbonDate->setTimeFromTimeString($data->hora);
            $f1 = Carbon::today();
            $f1 -> addDays(31);
            while ($carbonDate->lessThan($f1))
            {
                $date = date_create($carbonDate);
                $nuevo_viaje = Viaje::create([
                    'titulo' => $data['titulo'],
                    'origen' => $data['origen'],
                    'destino' => $data['destino'],
                    'fecha' => date_format($date,'Y-m-d H:i'),
                    'precio' => $data['precio'],
                    'tipo_viaje' => $data['tipo_viaje'],
                    'id_vehiculo' => $data['id_vehiculo'],
                    'id' => $user['id'],
                ]);
                $grupoViaje = GruposViaje::create([
                    'id_grupo' => $grupo->id_grupo,
                    'id_viaje' => $nuevo_viaje->id_viaje,
                ]);
                $carbonDate -> addDays($dias);
            }
        }
    } 

    public function publicarViaje(Request $data)
    {
        if ($data->titulo == null){
            $data['titulo'] = "Viaje desde " . $data['origen'] . " hacia " . $data['destino'];
        }
        $data['precio'] = $data->precio * 1.1;

        $this->validateViaje($data);

        $user = Auth::user();

        $firstDate = date_create($data['fecha'] . $data['hora']);
        $grupo = Grupo::create([
            'titulo' => $data['titulo'],
            'origen' => $data['origen'],
            'destino' => $data['destino'],
            'fecha' => $firstDate,
            'precio' => $data['precio'],
            'tipo_viaje' => $data['tipo_viaje'],
            'id_vehiculo' => $data['id_vehiculo'],
            'id' => $user['id'],
        ]);
        $data['id_grupo'] = $grupo->id_grupo;
        $this->createViajes($data);
        
        return redirect('/viajes/crearViaje')->with('mensajeSuccess', '¡El viaje ha sido publicado correctamente!');
    }

    protected function vehiculosUsuario()
    {
        $user = Auth::user();
        $registras = Registra::all();
        $mis_vehiculos = array();
        foreach ($registras as $registra)
        {
            if($registra['id'] == $user['id']){
                $mis_vehiculos[] = Vehiculo::find($registra['id_vehiculo']);
            }
        }
        return $mis_vehiculos;
    }

    public function misViajes()
    {
        $today = Carbon::today();

        $user = Auth::user();


        $mis_grupos = Grupo::where('id','like',$user['id'])->orderBy('fecha', 'asc')->get();
        $postuPorGrupo = array();
        if(($mis_grupos != '[]')){
            foreach($mis_grupos as $grupo)
            {
                $relacionDelGrupo = GruposViaje::where('id_grupo','=',$grupo->id_grupo)->get();
                $mis_viajes = array();
                foreach($relacionDelGrupo as $relacion){
                    $temp_viaje = Viaje::find($relacion->id_viaje);
                    if ($temp_viaje->fecha > $today){
                        $mis_viajes[] = $temp_viaje;
                    }
                }
                $suma = 0;
                foreach($mis_viajes as $viaje)
                {
                    $suma = Postulacion::where('id_viaje','=',$viaje->id_viaje)->where('estado_postulacion','=','pendiente')->count() + $suma;
                }
                $postuPorGrupo[$grupo->id_grupo] = $suma;
            }
            return view('viajes.misViajes') -> with('mis_viajes', $mis_grupos)
            ->with('postuPorGrupo',$postuPorGrupo);
        } else {
            return redirect('/home')->with('info', 'sinViajes');
        }
    }

    public function modificarViaje($id)
    {
        //$postulaciones = ???
        //if ($postulaciones){
            $viaje = Grupo::find($id);
            $hora = explode(' ',$viaje->fecha)[1];
            $vehiculos = $this->vehiculosUsuario();
            return view('viajes.modificarViaje')->with('viaje',$viaje)
            ->with('vehiculos',$vehiculos)
            ->with('hora',$hora);
        //} else {
        //    return redirect('/viajes/misViajes')->with('mensajeDanger', '¡El viaje seleccionado no puede ser modificado! Tiene postulaciones para viajar.');
        //}
    }

    public function modificarViajeId(Request $data)
    {
        $mi_viaje = Viaje::find($data['id_viaje']);

        $mi_viaje->titulo = $data->input('titulo');
        $mi_viaje->origen = $data->input('origen');
        $mi_viaje->destino = $data->input('destino');
        $mi_viaje->fecha = $data->input('fecha');
        $mi_viaje->precio = $data->input('precio');
        $mi_viaje->tipo_viaje = $data->input('tipo_viaje');
        $mi_viaje->titulo = $data->input('titulo');
        $mi_viaje->save();

        return redirect("/viajes/modificarViaje/" . $mi_viaje->id_viaje);
    }

    protected function eliminarViajeId($id)
    {
        $mi_viaje = Viaje::find($id);
        $postulaciones = Postulacion::where('id_viaje','=',$id)->get();
        foreach ($postulaciones as $postulacion)
        {
            Postulacion::find($postulacion->id_postulacion)->delete();
        }
        DB::table('viajes')->where('id_viaje', '=', $mi_viaje->id_viaje)->delete();
    }

    public function eliminarViaje($id)
    {
        $this->eliminarViajeId($id);
        return redirect('/viajes/misViajes');
    }

    public function finalizarViaje($id_viaje)
    {
        $today = Carbon::now();
        $user = Auth::user();
        $viaje = Viaje::find($id_viaje);   

        if(!is_null($viaje)){
            if($user->id == $viaje->id){
                if ( $today > $viaje->fecha ){
                    $viaje->estado_viaje = 'finalizado';
                    $viaje->save();
                    $conf = Configuracion::find(1);
                    $conf->fondo = $conf->fondo + ceil( ceil(ceil($viaje->precio * 100) / 110) * 0.10  );
                    $conf->save(); 
                }
            }
        }
        return redirect()->back();
    }
}
