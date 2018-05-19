<?php

namespace App\Http\Controllers;

use App\User;
use App\Vehiculo;
use App\Registra;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Auth;

class VehiculosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  
    }

    public function modificarVehiculo($id)
    {
        //
        return view('vehiculos.modificarVehiculo');
    }
/*
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'patente' => 'required|string|min:1|max:255|unique:vehiculos',
            'marca' => 'required|string|min:1|max:255',
            'modelo' => 'required|string|min:1|max:1',
            'cantidad_asientos' => 'required|integer|min:2',
        ]);
    }
*/
    private function validateVehiculo($data){
        $data->validate([
            'patente' => 'required|string|min:1|max:255|unique:vehiculos',
            'marca' => 'required|string|min:1|max:255',
            'modelo' => 'required|string|min:1',
            'cantidad_asientos' => 'required|integer|min:1',
        ]);
    }

    public function agregarVehiculo(Request $data){

        $user = Auth::user();

        $this->validateVehiculo($data);

        $nuevo_vehiculo = Vehiculo::create([
            'patente' => $data['patente'],
            'marca' => $data['marca'],
            'modelo' => $data['modelo'],
            'cantidad_asientos' => $data['cantidad_asientos'],
        ]);

        $nuevo_registro = Registra::create([
            'id' => $user['id'],
            'id_vehiculo' => $nuevo_vehiculo['id_vehiculo'],
        ]);

        return redirect('mi_usuario');
    }

}
