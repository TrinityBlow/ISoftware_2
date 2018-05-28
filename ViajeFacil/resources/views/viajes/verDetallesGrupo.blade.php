@extends('layouts.layout')
@section('content')
<h5 class="card-title">Seleccione alguna/s de las fecha/s de viaje</h5>
@foreach ($viajes as $viaje)
<div class="card border-primary mb-3">
  <div class="card-body text-primary">
    <p class="card-text"><u>{{ $viaje -> origen }}</u> hacia <u>{{ $viaje -> destino }}</u> | <strong>{{ $viaje -> fecha }}</strong></p>
	<a href="/viajes/verDetallesViaje/{{ $viaje -> id_viaje }}" class="btn btn-primary">Ver detalles</a>
  </div>
</div>
@endforeach

@endsection