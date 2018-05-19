@extends('layouts.layout')

@section('content')
<div class="card text-center">
  <div class="card-header">
    Featured
  </div>
  <div class="card-body">
    <h5 class="card-title">{{ $viaje -> origen }} hacia {{ $viaje -> destino }}</h5>
    <p class="card-text">Precio del viaje: {{ $viaje -> precio }} </p>
    <p class="card-text">Tipo de viaje: {{ $viaje -> tipo_viaje }} </p>
    <button type="button" class="btn btn-success">Postularme para viajar</button>
    <button type="button" class="btn btn-info">Hacer consulta</button>
  </div>
  <div class="card-footer text-muted">
    2 days ago
  </div>
</div>
   {{$viaje}}
@endsection