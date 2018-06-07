@extends('layouts.layout')

@section('content')

@if($errors->any())
    <div class="alert alert-warning">
        <strong>{{$errors->first()}}</strong>
    </div>
@endif

<div class="container">
    @if($postulaciones->count() > 0)
        @foreach ($postulaciones->reverse() as $postulacion)
            <div class="card border-dark mb-2">
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <h5 class="card-title">Postulación para el viaje:</h5>
                            <p class="card-text">Origen: {{$postulacion->viaje->origen}} | Destino: {{$postulacion->viaje->destino}} | Fecha del viaje: {{$postulacion->viaje->fecha}} </p>
                        </li>
                        <li class="list-group-item">
                            <h5 class="card-title">Postulado: {{ $postulacion->user->name }}, {{ $postulacion->user->last_name }}</h5>
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
                        </li>
                    </ul>
                </div>
            </div>
        @endforeach
    @else
        <h5 class="card-title text-center">No se ha encontrado ninguna postulación</h5>
    @endif
</div>

@endsection
