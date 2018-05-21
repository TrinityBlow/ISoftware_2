<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Auth\RegistersUsers;
use Auth;
use App\Viaje;
use App\Postulacion;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */

    private function hacer (){        
       /* $user = Auth::user();
        return \App\Postulacion::all()->where('id','=',$user->id)->where('estado_postulacion','=','pendiente');*/        
        $f0 = Carbon::today();

        $f1 = Carbon::today();

        $f1 -> addDays(30);
        
        $user = Auth::user(); 
        $mis_viajes = Viaje::where('id','=',$user->id)->whereBetween('fecha', [$f0, $f1])->get();
        $re = collect();
        foreach ($mis_viajes as $viaje){
            $re = $re->merge(Postulacion::where('id_viaje','=',$viaje->id_viaje)
            ->where('id','!=',$user->id)
            ->where('estado_postulacion','=','pendiente')->get());
        }
        return $re;
    }

    public function boot()
    {
        // PARCHEA QUE NO SE ME PASEN LA CANTIDAD DE DATOS DE UN STRING
        Schema::defaultStringLength(191); 

        view()->composer('layouts.layout',function($view){
            $user = Auth::user();
            if($user){
                $view->with('postulaciones',$this->hacer() );
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
