@extends('layouts.layout')
@section('content')

  @foreach ($postulaciones->reverse() as $postulacion)
    <div class="card w-75 mt-2">
      <div class="card-body">
          <ul class="list-group list-group-flush">
              <li class="list-group-item">
                  <h3> Postulaciones para el viaje: </h3>
                  <h5>Origen: {{$postulacion->viaje->origen}}, Destino: {{$postulacion->viaje->destino}} </br>
                    Fecha: {{$postulacion->viaje->fecha}} Precio: {{$postulacion->viaje->precio}}</h5>
                  </br>
                
              </li>
              <li class="list-group-item">
                  <h5 class="card-title">Postulado: {{ $postulacion->user->name }}, {{ $postulacion->user->last_name }}.</h5>
                  <form method="POST" action="/viajes/manejarPostulacion">
                    @csrf
                    <input type="hidden" name="postulado_id" value={{ $postulacion->id }}>
                    <input type="hidden" name="id_postulacion" value={{ $postulacion->id_postulacion }}>
                    @if($postulacion->estado_postulacion == 'pendiente')
                      <button type="submit" name="action" value="aceptar" class="btn btn-success">Aceptar</button>
                      <button type="submit" name="action" value="rechazar" class="btn btn-danger">Rechazar</button>
                    @else
                      <h5>El postulado fue: {{$postulacion->estado_postulacion}}</h5>
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
@endsection