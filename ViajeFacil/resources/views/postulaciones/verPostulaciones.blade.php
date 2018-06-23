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
                                <button type="submit" name="action" value="rechazar" class="btn btn-danger">Rechazar</button>
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
@endsection
