<?php

namespace App\Http\Controllers;

use App\User;
use App\Vehiculo;
use App\Registra;
use App\Viaje;
use App\Postulacion;
use App\Pregunta;
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
        $f0 -> addDays(1);

        $f1 = Carbon::today();
        $f1 -> addDays(30);

        $vehiculos = $this->vehiculosUsuario();
        if (!count($vehiculos)){
            return redirect('/home')->with('info', 'sinVehiculos');
        }
        return view('viajes.crearViaje')
        ->with('vehiculos',$vehiculos)
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
        $preguntas = Pregunta::where('id_viaje','=',$viaje->id_viaje)->get();
        foreach ($preguntas as $pregunta)
        {
            $pregunta['id'] = User::find($pregunta->id);
        }
        return view('viajes.verDetallesViaje')
        ->with('usuario_creador',$usuario_creador)
        ->with('viaje',$viaje)
        ->with('vehiculo',$vehiculo)
        ->with('postulacion',$tiene_postulacion)
        ->with('preguntas',$preguntas);
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
        } elseif ((is_null($data['fecha1'])) and (is_null($data['fecha2']))){
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
            'fecha' => 'required|date',
            'precio' => 'required',
            'tipo_viaje' => 'required',
        ]);
    }    

    protected function createViajes(Request $data)
    {
        $user = Auth::user();
        $grupo = Grupo::find($data->id_grupo);
        if ($data->tipo_viaje == 'ocasional'){
            $nuevo_viaje = Viaje::create([
                'titulo' => $data['titulo'],
                'origen' => $data['origen'],
                'destino' => $data['destino'],
                'fecha' => $data['fecha'],
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
            $carbonDate = new Carbon($data['fecha']);
            $f1 = Carbon::now();
            $f1 -> addDays(30);
            while ($carbonDate->lte($f1))
            {
                $nuevo_viaje = Viaje::create([
                    'titulo' => $data['titulo'],
                    'origen' => $data['origen'],
                    'destino' => $data['destino'],
                    'fecha' => $carbonDate,
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

    private function tieneViajesSinFinalizar()
    {
        $user = Auth::user();
        $today = Carbon::now();

        $sin_finalizar = Viaje::where('id','=',$user->id)->where('fecha','<',$today)->whereNull('estado_viaje')->first();
        
        if (is_null($sin_finalizar)){
            return false;
        }
        return true;
    }

    private function tieneCalifaciones30Dias()
    {
        $user = Auth::user();
        $thristyDaysAgo = Carbon::now()->subDays(30);
        $viajes = Viaje::where('id','=',$user->id)->where('fecha','<',$thristyDaysAgo)->get();
        foreach($viajes as $viaje){
            if (!is_null(Postulacion::where('id_viaje','=',$viaje->id_viaje)->where('estado_postulacion','=','aceptado')->where('calificacion_viajero','=',null)->first()))
            {
                return true;
            }
        }
        return false;
    }

    private function tieneCalifaciones30DiasPasajero()
    {
        $user = Auth::user();
        $thristyDaysAgo = Carbon::now()->subDays(30);
        $postulaciones = Postulacion::where('id','=',$user->id)->get();
        foreach($postulaciones as $postulacion){
            if(Viaje::find($postulacion->id_viaje)->fecha < $thristyDaysAgo){
                if (is_null($postulacion->calificacion_viaje)){
                    return true;
                }
            }
        }
        return false;
    }

    public function publicarViaje(Request $data)
    {
        if (!$this->tieneViajesSinFinalizar()){
            if (!$this->tieneCalifaciones30Dias()){
                if(!$this->tieneCalifaciones30DiasPasajero()){
                    if ($data->titulo == null){
                        $data['titulo'] = "Viaje desde " . $data['origen'] . " hacia " . $data['destino'];
                    }
                    $data['fecha'] = new Carbon($data['fecha'] . $data['hora']);
                    $data['precio'] = $data->precio * 1.1;

                    $this->validateViaje($data);

                    $user = Auth::user();
                    $grupo = Grupo::create([
                        'titulo' => $data['titulo'],
                        'origen' => $data['origen'],
                        'destino' => $data['destino'],
                        'fecha' => $data['fecha'],
                        'precio' => $data['precio'],
                        'tipo_viaje' => $data['tipo_viaje'],
                        'id_vehiculo' => $data['id_vehiculo'],
                        'id' => $user['id'],
                    ]);
                    $data['id_grupo'] = $grupo->id_grupo;
                    $this->createViajes($data);
                    
                    return redirect('/viajes/crearViaje')->with('mensajeSuccess', '¡El viaje ha sido publicado correctamente!');
                }else{
                    return redirect()->back()->with('mensajeDanger', '¡El viaje no puede ser publicado! Tiene calificaciones pendientes de hace más de 30 días como pasajero.');
                }
            } else {
                return redirect()->back()->with('mensajeDanger', '¡El viaje no puede ser publicado! Tiene calificaciones pendientes de hace más de 30 días como conductor.');
            }
        } else {
            return redirect()->back()->with('mensajeDanger', '¡El viaje no puede ser publicado! Tiene viajes sin finalizar.');
        }
    }

    protected function vehiculosUsuario()
    {
        $user = Auth::user();
        $registras = Registra::all();
        $mis_vehiculos = array();
        foreach ($registras as $registra)
        {
            if ($registra['id'] == $user['id']){
                $mis_vehiculos[] = Vehiculo::find($registra['id_vehiculo']);
            }
        }
        return $mis_vehiculos;
    }

    public function misViajes()
    {
        $today = Carbon::now();

        $user = Auth::user();
        $mis_grupos = Grupo::where('id','like',$user['id'])->orderBy('fecha', 'asc')->get();
        $notificacionesPorGrupo = array();

        if ($mis_grupos != '[]'){
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
                $sumaPostulaciones = 0;
                $sumaPreguntas = 0;
                foreach($mis_viajes as $viaje)
                {
                    $sumaPostulaciones = Postulacion::where('id_viaje','=',$viaje->id_viaje)->where('estado_postulacion','=','pendiente')->count() + $sumaPostulaciones;
                    $sumaPreguntas = Pregunta::where('id_viaje','=',$viaje->id_viaje)->whereNull('respuesta')->count() + $sumaPreguntas;
                }
                $notificacionesPorGrupo[$grupo->id_grupo] = $sumaPostulaciones + $sumaPreguntas;
            }
            return view('viajes.misViajes') -> with('mis_viajes', $mis_grupos)
            ->with('notificacionesPorGrupo',$notificacionesPorGrupo);
        } else {
            return redirect('/home')->with('info', 'sinViajes');
        }
    }

/*
    public function misViajes2()
    {
        $today = Carbon::now();

        $user = Auth::user();
        $mis_grupos = Grupo::where('id','like',$user['id'])->orderBy('fecha', 'asc')->get();
        $postulacionesPorGrupo = array();
        $preguntasPorGrupo = array();

        if ($mis_grupos != '[]'){
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
                $sumaPostulaciones = 0;
                $sumaPreguntas = 0;
                foreach($mis_viajes as $viaje)
                {
                    $sumaPostulaciones = Postulacion::where('id_viaje','=',$viaje->id_viaje)->where('estado_postulacion','=','pendiente')->count() + $sumaPostulaciones;
                    $sumaPreguntas = Pregunta::where('id_viaje','=',$viaje->id_viaje)->whereNull('respuesta')->count() + $sumaPreguntas;
                }
                $postulacionesPorGrupo[$grupo->id_grupo] = $sumaPostulaciones;
                $preguntasPorGrupo[$grupo->id_grupo] = $sumaPreguntas;
            }
            return view('viajes.misViajes') -> with('mis_viajes', $mis_grupos)
            ->with('postulacionesPorGrupo',$postulacionesPorGrupo)
            ->with('preguntasPorGrupo',$preguntasPorGrupo);
        } else {
            return redirect('/home')->with('info', 'sinViajes');
        }
    }
*/

    protected function modificarViaje($id, $data)
    {
        $viaje = Viaje::find($id);

        $viaje->titulo = $data['titulo'];
        $viaje->origen = $data['origen'];
        $viaje->destino = $data['destino'];
        $viaje->precio = $data['precio'];
        $viaje->id_vehiculo = $data['id_vehiculo'];
        $viaje->save();
    }
    
    protected function eliminarViaje($id)
    {
        $mi_viaje = Viaje::find($id);

        $postulaciones = Postulacion::where('id_viaje','=',$id)->get();
        foreach ($postulaciones as $postulacion)
        {
            Postulacion::find($postulacion->id_postulacion)->delete();
        }

        $preguntas = Pregunta::where('id_viaje','=',$id)->get();
        foreach ($preguntas as $pregunta)
        {
            Pregunta::find($pregunta->id_pregunta)->delete();
        }

        DB::table('viajes')->where('id_viaje', '=', $mi_viaje->id_viaje)->delete();
    }

/*
    protected function eliminarViajeId2($id)
    {
        $mi_viaje = Viaje::find($id);

        $postulaciones = Postulacion::where('id_viaje','=',$id)->get();
        foreach ($postulaciones as $postulacion)
        {
            if ($postulacion->estado_postulacion == 'pendiente'){
                $postulacion->estado_postulacion = 'rechazado';
                 $postulacion->save();
            }
        }

        $preguntas = Pregunta::where('id_viaje','=',$id)->get();
        foreach ($preguntas as $pregunta)
        {
            Pregunta::find($pregunta->id_pregunta)->delete();
        }

        $mi_viaje->estado_viaje = 'eliminado';
        $mi_viaje->save();
    }
*/

/*
    public function eliminarViaje3($id)
    {
        $this->eliminarViajeId($id);
        return redirect('/viajes/misViajes');
    }
*/

    public function finalizarViaje(Request $data)
    {
        $user = Auth::user();
        $today = Carbon::now();
        $viaje = Viaje::find($data->id_viaje);

        if (!is_null($viaje)){
            if ($user->id == $viaje->id){
                if ($today > $viaje->fecha){
                    $viaje->estado_viaje = 'finalizado';
                    $viaje->save();

                    $postulaciones = Postulacion::where('id_viaje','=',$viaje->id_viaje)->get();
                    foreach ($postulaciones as $postulacion)
                    {
                        if ($postulacion->estado_postulacion != 'aceptado'){
                            Postulacion::find($postulacion->id_postulacion)->delete();
                        }
                    }

                    $preguntas = Pregunta::where('id_viaje','=',$viaje->id_viaje)->get();
                    foreach ($preguntas as $pregunta)
                    {
                        Pregunta::find($pregunta->id_pregunta)->delete();
                    }

                    $conf = Configuracion::find(1);
                    $conf->fondo = $conf->fondo + ceil( ceil(ceil($viaje->precio * 100) / 110) * 0.10  );
                    $conf->save(); 
                }
            }
        }
        
        return redirect()->back()->with('mensajeSuccess', '¡El pago ha sido realizado correctamente!');
    }
}
