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

                        <button type="submit" class="btn btn-primary mt-3">Calificar</button>

                    </form>

                @else
                    <strong>Viajero calificado</strong>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
