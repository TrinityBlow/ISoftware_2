@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="card text-center">
        <div class="card-header">
            Viaje de: {{ $usuario_creador -> name }}
            {{ $usuario_creador -> last_name }}
        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $viaje -> titulo }}</h5>
            <p class="card-text">Fecha del viaje: {{ $viaje -> fecha }} </p>
            <p class="card-text">Precio del viaje: {{ $viaje -> precio }} </p>
            <p class="card-text">Tipo de viaje: {{ $viaje -> tipo_viaje }} </p>
            @if( $viaje->id == Auth::user()->id)
                <span> Este es mi viaje </span> <a href="#"> <button type="button" class="btn btn-success">Modificar</button> </a>
            @else
                @if( is_null($postulacion) )
                    <a href="/viajes/postularmeViaje/{{ $viaje->id_viaje }}"> <button type="button" class="btn btn-success">Postularme para viajar</button> </a>
                @else
                    @if( $postulacion->estado_postulacion == 'pendiente')
                        <a href="/viajes/cancelarPostulacion/{{ $viaje->id_viaje }}"> <button type="button" class="btn btn-warning">Cancelar postulación</button> </a>
                    @else
                        <strong> Usted fue {{$postulacion->estado_postulacion}} </strong>
                        @if($postulacion->estado_postulacion == 'aceptado')
                            <a href="/viajes/rechazarPostulacionViajante/{{ $viaje->id_viaje }}"> <button type="button" class="btn btn-warning">Rechazar viaje</button> </a>
                        @endif
                    @endif
                @endif
                <button type="button" class="btn btn-info">Hacer consulta</button>
            @endif
        </div>
    </div>
</div>
@endsection
