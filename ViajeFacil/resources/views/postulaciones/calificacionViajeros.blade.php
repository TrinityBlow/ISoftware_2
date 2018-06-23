@extends('layouts.layout')

@section('content')
<div class="container">
    <ul class="list-group mb-2">
        <p class="list-group-item bg-light">Viaje desde <strong>{{ $calificaciones[0] -> viaje -> origen }}</strong> hacia <strong>{{ $calificaciones[0] -> viaje -> destino }}</strong> a las <strong>{{ \Carbon\Carbon::parse($calificaciones[0] -> viaje -> fecha)->format('H:i') }}</strong> el día <strong>{{ \Carbon\Carbon::parse($calificaciones[0] -> viaje -> fecha)->format('d/m/Y') }}</strong></p>
    </ul>
    @foreach ($calificaciones as $calificacion)
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">Viajero: {{ $calificacion->user->name }}, {{ $calificacion->user->last_name }}</h5>
                <p>Su calificación: @if ($calificacion->calificacion_viaje == 1) Bueno @elseif ($calificacion->calificacion_viaje == 0) Neutral @else Malo @endif</p>
                @if (!is_null($calificacion->comentario_viaje)) <p>Su comentario: "{{ $calificacion->comentario_viaje }}"</p> @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
