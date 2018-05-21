@extends('layouts.layout')

@section('content')
<div class="card text-center">
  <div class="card-header">
    Viaje de: {{ $usuario_creador -> name }}
     {{ $usuario_creador -> last_name }}
  </div>
  <div class="card-body">
    <h5 class="card-title">{{ $viaje -> origen }} hacia {{ $viaje -> destino }}</h5>
    <p class="card-text">Fecha del viaje: {{ $viaje -> fecha }} </p>
    <p class="card-text">Precio del viaje: {{ $viaje -> precio }} </p>
    <p class="card-text">Tipo de viaje: {{ $viaje -> tipo_viaje }} </p>
    <a href="/viajes/postularmeViaje/{{ $viaje->id_viaje }}"> <button type="button" class="btn btn-success">Postularme para viajar</button> </a> 
    <button type="button" class="btn btn-info">Hacer consulta</button>
  </div>
</div>
@endsection