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
            $viajes = Grupo::whereBetween('fecha', [$f0, $f1])->where('origen','like',$filtroOrigen)->get();
        } elseif ((is_null($data['ori'])) and (!is_null($data['dest']))) {
            $filtroDestino = $data['dest'];
            $viajes = Grupo::whereBetween('fecha', [$f0, $f1])->where('destino','like','%'.$filtroDestino.'%')->get();
        } elseif ((!is_null($data['ori'])) and (!is_null($data['dest']))) {
           $filtroOrigen = $data['ori'];
           $filtroDestino = $data['dest'];
           $viajes = Grupo::whereBetween('fecha', [$f0, $f1])->where('origen','like','%'.$filtroOrigen.'%')->where('destino','like','%'.$filtroDestino.'%')->get();
        } else {
           $viajes = Grupo::whereBetween('fecha', [$f0, $f1])->get();
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

    protected function createViajes(Request $data){
        $user = Auth::user();
        $grupo = Grupo::find($data->id_grupo);
        if($data->tipo_viaje == 'ocasional'){
            $nuevo_viaje = Viaje::create([
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
        } else{
            if ($data->tipo_viaje == 'diario'){
                $dias = 1;
            }else{
                $dias = 7;
            }
            $date = explode('-',$data->fecha);
            $carbonDate = Carbon::createFromDate($date[0],$date[1],$date[2]);
            $carbonDate->setTimeFromTimeString($data->hora);
            $f1 = Carbon::today();
            $f1 -> addDays(31);
            while ($carbonDate->lessThan($f1)){

                $date = date_create($carbonDate);
                $nuevo_viaje = Viaje::create([
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

    public function publicarViaje(Request $data){
        $this->validateViaje($data);

        $user = Auth::user();

        $firstDate = date_create($data['fecha'] . $data['hora']);
        $grupo = Grupo::create([
            'origen' => $data['origen'],
            'destino' => $data['destino'],
            'fecha' => $firstDate,
            'precio' => $data['precio'],
            'titulo' => 'nada',
            'tipo_viaje' => $data['tipo_viaje'],
            'id_vehiculo' => $data['id_vehiculo'],
            'id' => $user['id'],
        ]);
        $data['id_grupo'] = $grupo->id_grupo;
        $this->createViajes($data);
        
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
        $mis_viajes = Grupo::where('id','like',$user['id'])->get();
        return view('viajes.misViajes') -> with('mis_viajes', $mis_viajes);
    }

    public function modificarViaje($id)
    {
        //
        $viaje = Grupo::find($id);
        $hora = explode(' ',$viaje->fecha)[1];
        $vehiculos = $this->vehiculosUsuario();
        return view('viajes.modificarViaje')->with('viaje',$viaje)
        ->with('vehiculos',$vehiculos)
        ->with('hora',$hora);
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

    protected function eliminarViajeId($id){
        $mi_viaje = Viaje::find($id);
        $postulaciones = Postulacion::where('id_viaje','=',$id)->get();
        foreach ($postulaciones as $postulacion){
            Postulacion::find($postulacion->id_postulacion)->delete();
        }
        DB::table('viajes')->where('id_viaje', '=', $mi_viaje->id_viaje)->delete();
    }

    public function eliminarViaje($id)
    {
        
        $this->eliminarViajeId($id);
        return redirect('/mi_usuario');
    }


}
