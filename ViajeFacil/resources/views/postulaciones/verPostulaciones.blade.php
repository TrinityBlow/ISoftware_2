@extends('layouts.layout')

@section('content')
<div class="container">
    @if($postulaciones->count() > 0)
        <ul class="list-group mb-2">
            <p class="list-group-item bg-light">Viaje desde <strong>{{ $postulaciones[0] -> viaje -> origen }}</strong> hacia <strong>{{ $postulaciones[0] -> viaje -> destino }}</strong> a las <strong>{{ \Carbon\Carbon::parse($postulaciones[0] -> viaje -> fecha)->format('H:i') }}</strong> el día <strong>{{ \Carbon\Carbon::parse($postulaciones[0] -> viaje -> fecha)->format('d/m/Y') }}</strong></p>
        </ul>
        @foreach ($postulaciones->reverse() as $postulacion)
            <div class="card mb-2">
                <div class="card-body">
                    <h5 class="card-title">Postulado: {{ $postulacion->user->name }}, {{ $postulacion->user->last_name }}</h5>
                    <p class="card-text">Reputación: {{ $postulacion->user->reputacion }}</p>
                    <form method="POST" action="/viajes/manejarPostulacion">
                        @csrf
                        <input type="hidden" name="postulado_id" value={{ $postulacion->id }}>
                        <input type="hidden" name="id_postulacion" value={{ $postulacion->id_postulacion }}>
                        @if($postulacion->estado_postulacion == 'pendiente')
                            <button type="submit" name="action" value="aceptar" class="btn btn-success">Aceptar</button>
                            <button type="submit" name="action" value="rechazar" class="btn btn-danger">Rechazar</button>
                        @else
                            <p class="card-text">El postulado fue: <strong>{{$postulacion->estado_postulacion}}</strong></p>
                            @if($postulacion->estado_postulacion == 'aceptado')
                                <button type="submit" name="action" value="rechazar" class="btn btn-danger" data-toggle="modal" data-target="#myModal3">Rechazar</button>
                            @endif
                        @endif
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <ul class="list-group">
            <p class="list-group-item bg-light text-center">No se ha encontrado ninguna postulación</p>
        </ul>
    @endif
</div>

<!-- Modal3 -->
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
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
