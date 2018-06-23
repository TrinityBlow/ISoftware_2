@extends('layouts.layout')

@section('content')
<div class="container">
    <ul class="list-group mb-2">
        <p class="list-group-item bg-light">Viaje desde <strong>{{ $viajeros[0] -> viaje -> origen }}</strong> hacia <strong>{{ $viajeros[0] -> viaje -> destino }}</strong> a las <strong>{{ \Carbon\Carbon::parse($viajeros[0] -> viaje -> fecha)->format('H:i') }}</strong> el día <strong>{{ \Carbon\Carbon::parse($viajeros[0] -> viaje -> fecha)->format('d/m/Y') }}</strong></p>
    </ul>
    @foreach ($viajeros as $viajero)
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">Viajero: {{ $viajero->user->name }}, {{ $viajero->user->last_name }}</h5>
                @if (is_null($viajero->calificacion_viajero))
                    <p class="card-text">¿Cómo calificaría al viajero?</p>

                    <form method="POST" action="/postulaciones/calificarViajero">
                        @csrf

                        <input type="hidden" name="id_viaje" value={{ $viajero->id_viaje }}>
                        <input type="hidden" name="id" value={{ $viajero->id }}>

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="calificacion" value="1">
                            <label class="form-check-label" for="calificacion">
                                Bueno
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="calificacion" value="0" checked>
                            <label class="form-check-label" for="calificacion">
                                Neutral
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="calificacion" value="-1">
                            <label class="form-check-label" for="calificacion">
                                Malo
                            </label>
                        </div>
                        <div class="form-group mt-3">
                            <textarea type="text" class="form-control" rows="3" name="comentario" placeholder="Escribe tu comentario aquí... (Opcional)"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Calificar</button>

                    </form>

                @else
                    <p>Mi calificación: @if ($viajero->calificacion_viajero == 1) Bueno @elseif ($viajero->calificacion_viajero == 0) Neutral @else Malo @endif</p>
                    @if (!is_null($viajero->comentario_viajero)) <p>Mi comentario: "{{ $viajero->comentario_viajero }}"</p> @endif
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
