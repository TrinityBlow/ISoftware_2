@extends('layouts.layout')

@section('content')
<div class="container">
@foreach ($viajes as $viaje)
	<div class="card mb-2">
			<div class="card-body">
					<h5 class="card-title">{{ $viaje -> titulo }}</h5>
					<a href="/viajes/verDetallesViaje/{{ $viaje -> id_viaje }}" class="btn btn-info">Ver detalles</a>
			</div>
	</div>
@endforeach
</div>
@endsection
