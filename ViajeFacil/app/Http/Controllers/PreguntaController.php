<?php

namespace App\Http\Controllers;

use App\User;
use App\Viaje;
use App\Grupo;
use App\GruposViaje;
use App\Pregunta;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Auth;

class PreguntaController extends Controller
{
    public function __construct()
    {
        // Verificacion necesaria en controller para que tenga permiso de usuario.
        $this->middleware('auth');
    }

    private function validatePregunta($data)
    {
        $data->validate([
            'consigna' => 'required|string|min:1|max:2000',
        ]);
    }

    public function publicarPregunta(Request $data)
    {
        $user = Auth::user();

        $this->validatePregunta($data);

        $pregunta = Pregunta::create([
            'consigna' => $data['consigna'],
            'id_viaje' => $data['id_viaje'],
            'id' => $user['id'],
        ]);

        return redirect()->back()->with('mensajeSuccess','¡Su pregunta ha sido publicada correctamente!');
    }

    private function validateRespuesta($data)
    {
        $data->validate([
            'respuesta' => 'required|string|min:1|max:2000',
        ]);
    }

    public function responderPregunta(Request $data)
    {
        $pregunta = Pregunta::find($data['id_pregunta']);

        $this->validateRespuesta($data);
        
        $pregunta->respuesta = $data->input('respuesta');
        
        $pregunta->save();

        return redirect()->back()->with('mensajeSuccess','¡La pregunta ha sido respondida correctamente!');
    }

}
