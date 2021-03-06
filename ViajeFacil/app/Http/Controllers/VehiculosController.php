<?php

namespace App\Http\Controllers;

use App\User;
use App\Vehiculo;
use App\Registra;
use App\Grupo;
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

        return redirect('/mi_usuario')->with('mensajeSuccess','¡El vehículo ha sido agregado correctamente!');
    }

    private function enUso($id)
    {
        $mis_viajes = Grupo::where('id_vehiculo','=',$id)->first();
        if (is_null($mis_viajes)) {
            return false;
        }
        return true;
    }
    
    public function modificarVehiculo($id)
    {
        if (!$this->enUso($id)) {
            $mi_vehiculo = Vehiculo::find($id);
            return view('vehiculos.modificarVehiculo')->with('mi_vehiculo',$mi_vehiculo);
        }
        return redirect()->back()->with('mensajeDanger', '¡El vehículo seleccionado no puede ser modificado! Está siendo utilizado para viajar.');
    }

    private function validateVehiculoModificar($data,$mi_vehiculo)
    {
        if ($mi_vehiculo->patente ==  $data['patente']){
            $data->validate([
                'cantidad_asientos' => 'required|integer|min:1',
            ]);
        } else {
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

        return redirect('/mi_usuario')->with('mensajeSuccess','¡El vehículo ha sido modificado correctamente!');
    }

    public function eliminarVehiculo(Request $data)
    {
        if (!$this->enUso($data->id_vehiculo)) {
            $mi_vehiculo = Vehiculo::find($data->id_vehiculo);
            DB::table('registra')->where('id_vehiculo', '=', $mi_vehiculo->id_vehiculo)->delete();
            return redirect('/mi_usuario')->with('mensajeSuccess','¡El vehículo ha sido eliminado correctamente!');
        }
        return redirect()->back()->with('mensajeDanger', '¡El vehículo seleccionado no puede ser eliminado! Está siendo utilizado para viajar.');
    }
}
