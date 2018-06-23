@extends('layouts.layout')

@section('content')
<div class="container">

    <div class="card mb-2">
        <div class="card-header text-center">Viaje de: <strong>{{ $usuario_creador -> name }}, {{ $usuario_creador -> last_name }}</strong></div>

        <div class="card-body">
            <div class="row form-group">
                <div class="col">
                    <h5 class="card-title">{{ $viaje -> titulo }}</h5>
                    <p class="card-text">Fecha: {{ \Carbon\Carbon::parse($viaje -> fecha)->format('d/m/Y') }}</p>
                    <p class="card-text">Hora: {{ \Carbon\Carbon::parse($viaje -> fecha)->format('H:i') }}</p>
                    <p class="card-text">Precio: ${{ ceil($viaje -> precio) }}</p>
                    <p class="card-text">Vehículo: {{ $vehiculo -> marca }} {{ $vehiculo -> modelo }}</p>
                </div>
                <div class="col">
                    <img class="rounded img-thumbnail float-right" src='/storage/images/{{ $usuario_creador->image }}' height="auto" width="50%">
                </div>
            </div>
            <div class="row form-group">
                <div class="col">
                    @if( $viaje->id == Auth::user()->id )
                        <strong> Este es mi viaje </strong>
                    @else
                        @if(is_null($postulacion))
                            <a href="/viajes/postularmeViaje/{{ $viaje->id_viaje }}"> <button type="button" class="btn btn-success">Postularme para viajar</button> </a>
                        @else
                            @if($postulacion->estado_postulacion == 'pendiente')
                                <a href="/viajes/cancelarPostulacion/{{ $viaje->id_viaje }}"> <button type="button" class="btn btn-warning">Cancelar postulación</button> </a>
                            @else
                                <strong> Usted fue {{$postulacion->estado_postulacion}} </strong>
                                @if($postulacion->estado_postulacion == 'aceptado')
                                    <button class="btn btn-warning" data-id="{{ $viaje->id_viaje }}" data-toggle="modal" data-target="#myModal">Rechazar viaje</button>
                                @endif
                            @endif
                        @endif
                    @endif
                </div>
                <div class="col">
                    <h5 class="text-right">Reputación: {{ $usuario_creador -> reputacion }}</h5>
                </div>
            </div>
        </div>

    </div>

    @if($viaje->estado_viaje != 'finalizado')
        <div class="card">
            @if( $viaje->id != Auth::user()->id)
                <div class="card-header text-center">Realizar pregunta</div>

                <div class="card-body">
                    <form method="POST" action="/pregunta/publicarPregunta">
                        @csrf

                        <input type="hidden" name="id_viaje" value={{ $viaje->id_viaje }}>
                        <input type="hidden" name="id" value={{ Auth::user()->id }}>

                        <div class="form-group">
                            <textarea type="text" class="form-control" rows="3" name="consigna" placeholder="Escribe tu pregunta aquí..."></textarea>
                        </div>
                        
                        <div class="form-group"> <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Publicar pregunta</button>
                        </div>

                    </form>
                </div>
            @endif
            <ul class="list-group list-group-flush">
                @if($preguntas != '[]')
                    <p class="list-group-item bg-light text-center">Preguntas realizadas</p>

                    @foreach ($preguntas->reverse() as $pregunta)
                        <li class="list-group-item">
                            <p class="list-group-item-heading"><strong>{{ $pregunta -> id -> name }}, {{ $pregunta -> id -> last_name }}</strong> pregunta:</p>
                            <p class="list-group-item-text">{{ $pregunta -> consigna }}</p>
                            @if(!is_null($pregunta -> respuesta))
                                <div class="offset-1">
                                    <p class="text-muted list-group-item-heading">Respuesta:</p>
                                    <p class="text-muted list-group-item-text">{{ $pregunta -> respuesta }}</p>
                                </div>
                            @elseif ($viaje->id == Auth::user()->id)
                                <div class="offset-1">
                                    <form method="POST" action="/pregunta/responderPregunta">
                                        @csrf

                                        <input type="hidden" name="id_pregunta" value={{ $pregunta->id_pregunta }}>
                                        
                                        <div class="form-group">
                                            <textarea type="text" class="form-control" rows="3" name="respuesta" placeholder="Escribe tu respuesta aquí..."></textarea>
                                        </div>
                                        
                                        <div class="form-group"> <!-- Submit Button -->
                                            <button type="submit" class="btn btn-primary float-right">Responder</button>
                                        </div>

                                    </form>
                                </div>
                            @endif
                        </li>
                    @endforeach
                @else
                    <p class="list-group-item bg-light text-center">No se han realizado preguntas</p>
                @endif
            </ul>
        </div>
    @endif

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Eliminar viaje</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="/viajes/rechazarPostulacionViajante">
                @csrf
                <div class="modal-body">
                    <p>¿Estás seguro que quieres rechazar el viaje?</br>Se te restará 1 punto de reputación.</p>
                    <input type="hidden" id="id_modal" name="id_viaje" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="submit" class="btn btn-danger">Sí, estoy seguro</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
