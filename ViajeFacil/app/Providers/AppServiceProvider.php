<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;
use App\Viaje;
use App\Postulacion;
use App\Pregunta;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    protected function postulaciones ()
    {        
        /* $user = Auth::user();
        return \App\Postulacion::all()->where('id','=',$user->id)->where('estado_postulacion','=','pendiente');*/        
        $f0 = Carbon::now();

        $f1 = Carbon::now();

        $f1 -> addDays(30);
        
        $user = Auth::user(); 
        $mis_viajes = Viaje::where('id','=',$user->id)->whereBetween('fecha', [$f0, $f1])->get();
        $postulaciones = collect();
        foreach ($mis_viajes as $viaje){
            $postulaciones = $postulaciones->merge(Postulacion::where('id_viaje','=',$viaje->id_viaje)
            ->where('id','!=',$user->id)
            ->where('estado_postulacion','=','pendiente')->get());
        }
        return $postulaciones;
    }

    protected function preguntas ()
    {        
        $f0 = Carbon::now();

        $f1 = Carbon::now();

        $f1 -> addDays(30);
        
        $user = Auth::user(); 
        $mis_viajes = Viaje::where('id','=',$user->id)->whereBetween('fecha', [$f0, $f1])->get();
        $preguntas = collect();
        foreach ($mis_viajes as $viaje){
            $preguntas = $preguntas->merge(Pregunta::where('id_viaje','=',$viaje->id_viaje)
            ->whereNull('respuesta')->get());
        }
        return $preguntas;
    }

    public function boot()
    {
        // PARCHEA QUE NO SE PASE LA CANTIDAD DE DATOS DE UN STRING.
        Schema::defaultStringLength(191);
        // Establece la zona horaria predeterminada ya que por defecto usa "UTC".
        date_default_timezone_set('America/Argentina/Buenos_Aires');

        view()->composer('layouts.layout',function($view){
            $user = Auth::user();
            if($user){
                $view->with('postulaciones',$this->postulaciones())->with('preguntas',$this->preguntas());
            }
        });


    }

    /**
     * Register any application services.
     *
     * @return void
     */

    public function register()
    {
        //
    }
}
