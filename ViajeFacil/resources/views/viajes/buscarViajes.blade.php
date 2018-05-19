@extends('layouts.layout')

@section('content')
@foreach ($viajes as $viaje)
	<div class="card w-75 mb-2">
	  <div class="card-body">
	  		<h5 class="card-title">{{ $viaje -> origen }} hacia {{ $viaje -> destino }}</h5>
	    <a href="/viajes/verDetallesViaje/{{ $viaje -> id_viaje }}" class="btn btn-primary">Ver detalles</a>
	  </div>
	</div>
@endforeach
@endsection