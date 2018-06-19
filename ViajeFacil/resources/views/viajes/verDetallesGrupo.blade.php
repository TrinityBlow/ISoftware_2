@extends('layouts.layout')

@section('content')
<div class="container">
    
    <ul class="list-group mb-2">
        <p class="list-group-item bg-light">Viajes desde <strong>{{ $viajes[0] -> origen }}</strong> hacia <strong>{{ $viajes[0] -> destino }}</strong> a las <strong>{{ \Carbon\Carbon::parse($viajes[0] -> fecha)->format('H:i') }}</strong></p>
    </ul>
    @foreach ($viajes as $viaje)
        <div class="card mb-2">
            <div class="card-body">
                <h5 class="card-title">Fecha: {{ \Carbon\Carbon::parse($viaje -> fecha)->format('d/m/Y') }}</h5>
                <a href="/viajes/verDetallesViaje/{{ $viaje -> id_viaje }}" class="btn btn-info">Ver detalles</a>
            </div>
        </div>
    @endforeach

</div>
@endsection
