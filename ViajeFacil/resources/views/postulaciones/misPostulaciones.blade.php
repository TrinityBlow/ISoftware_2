@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="card">
        @csrf
        <div class="card-header">Mis postulaciones</div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Precio</th>
                            <th>Estado postulación</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($postulaciones->reverse() as $postulacion)
                            <tr>
                                <td> {{ $postulacion->id_viaje->origen }} </td> 
                                <td> {{ $postulacion->id_viaje->destino }} </td>
                                <td> {{ \Carbon\Carbon::parse($postulacion->id_viaje->fecha)->format('d/m/Y') }} </td>
                                <td> {{ \Carbon\Carbon::parse($postulacion->id_viaje->fecha)->format('H:i') }} </td>
                                <td> ${{ ceil($postulacion->id_viaje->precio) }} </td>
                                <td> {{ ucfirst($postulacion->estado_postulacion) }} </td>
                                <td>
                                    <div class="container">
                                        <div class="row">
                                            @if($postulacion->id_viaje->estado_viaje != 'finalizado')
                                                <a href="/viajes/verDetallesViaje/{{ $postulacion->id_viaje->id_viaje }}" class="btn btn-info btn-sm">
                                                    Ver detalles del viaje
                                                </a>
                                            @else
                                                <strong>Viaje finalizado</strong>
                                                @if($postulacion->estado_postulacion == 'aceptado')
                                            <button class="btn btn-primary btn-sm" data-id="{{ $postulacion }}" data-toggle="modal" data-target="#myModal{{$postulacion->id_postulacion}}">
                                                        Calificar viaje
                                                    </button>
                                                @endif
                                            @endif
                                        </div>
									</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Modal -->
@foreach ($postulaciones->reverse() as $postulacion)
    <div class="modal fade" id="myModal{{$postulacion->id_postulacion}}" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenterTitle">Calificar viaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="/postulaciones/calificarViaje">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id_modal" name="postulacion" value="">

                        @if (is_null($postulacion->calificacion_viaje))
                            ¿Cómo calificaría el viaje?
                            <input type="hidden" name="id_viaje" value={{ $postulacion->id_viaje->id_viaje }}>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="calificacion" value="1">
                                <label class="form-check-label" for="calificacion">
                                    Bueno
                                </label>
                                </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="calificacion" value="0" checked>
                                <label class="form-check-label" for="calificacion">
                                    Neutral
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="calificacion" value="-1">
                                <label class="form-check-label" for="calificacion">
                                    Malo
                                </label>
                            </div>
                            <div class="form-group mt-3">
                                <textarea type="text" class="form-control" rows="3" name="comentario" placeholder="Escribe tu comentario aquí... (Opcional)"></textarea>
                            </div>
                        @else
                            <p>Mi calificación: @if ($postulacion->calificacion_viaje == 1) Bueno @elseif ($postulacion->calificacion_viaje == 0) Neutral @else Malo @endif</p>
                            @if (!is_null($postulacion->comentario_viaje)) <p>Mi comentario: "{{ $postulacion->comentario_viaje }}"</p> @endif
                            <hr>
                            @if (!is_null($postulacion->calificacion_viajero))
                                <p>Su calificación: @if ($postulacion->calificacion_viajero == 1) Bueno @elseif ($postulacion->calificacion_viajero == 0) Neutral @else Malo @endif</p>
                                @if (!is_null($postulacion->comentario_viajero)) <p>Su comentario: "{{ $postulacion->comentario_viajero }}"</p> @endif
                            @endif
                        @endif

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        @if (is_null($postulacion->calificacion_viaje))
                            <button type="submit" class="btn btn-primary">Calificar</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

@endsection
