@extends('layouts.layout')

@section('content')
<div class="container">

    <h5 class="card-title text-center">Seleccione alguna/s de las fecha/s de viaje</h5>
    
    @foreach ($viajes as $viaje)
        <div class="card mb-2">

            <div class="card-body">
                <p class="card-text"><u>{{ $viaje -> origen }}</u> hacia <u>{{ $viaje -> destino }}</u> | <strong>{{ $viaje -> fecha }}</strong></p>
                <a href="/viajes/verDetallesViaje/{{ $viaje -> id_viaje }}" class="btn btn-info">Ver detalles</a>
            </div>

        </div>
    @endforeach

</div>
@endsection
