<?php

namespace App\Http\Controllers;

use App\User;
use App\Vehiculo;
use App\Registra;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Auth;

class VehiculosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  
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

    private function validateVehiculo($data)
    {
        $data->validate([
            'patente' => 'required|string|min:1|max:255|unique:vehiculos',
            'marca' => 'required|string|min:1|max:255',
            'modelo' => 'required|string|min:1',
            'cantidad_asientos' => 'required|integer|min:1',
        ]);
    }

    public function agregarVehiculo(Request $data)
    {
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

        return redirect('/mi_usuario');
    }

    public function modificarVehiculo($id)
    {
        $mi_vehiculo = Vehiculo::find($id);
        return view('vehiculos.modificarVehiculo')->with('mi_vehiculo',$mi_vehiculo);
    }

    private function validateVehiculoModificar($data,$mi_vehiculo)
    {
        if ($mi_vehiculo->patente ==  $data['patente']){
            $data->validate([
                'cantidad_asientos' => 'required|integer|min:1',
            ]);
        }else{
            $data->validate([
                'patente' => 'required|string|min:1|max:255|unique:vehiculos',
                'cantidad_asientos' => 'required|integer|min:1',
            ]);
        }
    }

    public function modificarVehiculoPorId(Request $data)
    {
        $mi_vehiculo = Vehiculo::find($data['id_vehiculo']);
        $this->validateVehiculoModificar($data,$mi_vehiculo);
        
        $mi_vehiculo->patente = $data->input('patente');
        $mi_vehiculo->modelo = $data->input('modelo');
        $mi_vehiculo->marca = $data->input('marca');
        $mi_vehiculo->cantidad_asientos = $data->input('cantidad_asientos');

        $mi_vehiculo->save();

        return redirect("/vehiculos/modificarVehiculo/" . $mi_vehiculo->id_vehiculo);
    }

    public function eliminarVehiculo(Request $data)
    {
        $mi_vehiculo = Vehiculo::find($data->id_vehiculo);
        DB::table('registra')->where('id_vehiculo', '=', $mi_vehiculo->id_vehiculo)->delete();
        return redirect('/mi_usuario');
    }

}
