@extends('layouts.layout', ['postulaciones',$postulaciones], ['preguntas',$preguntas])

@section('content')
<div class="container">
    <div class="card">
        @csrf
        <div class="card-header">Mis viajes</div>

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
                            <th>Tipo de viaje</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mis_viajes->reverse() as $viaje)
                            <tr>
                                <td> {{ $viaje -> origen }} </td> 
                                <td> {{ $viaje -> destino }} </td>
                                <td> {{ \Carbon\Carbon::parse($viaje -> fecha)->format('d/m/Y') }} </td>
                                <td> {{ \Carbon\Carbon::parse($viaje -> fecha)->format('H:i') }} </td>
                                <td> ${{ ceil($viaje -> precio) }} </td>
                                <td> {{ ucfirst($viaje -> tipo_viaje) }} </td>
                                <td>
                                    <div class="btn-group-vertical" style="width:100%">
                                        <a href="/viajes/verViajesDetalle/{{ $viaje->id_grupo }}" class="btn btn-info btn-sm">
                                            Ver detalles de viajes
                                            @if($notificacionesPorGrupo[$viaje->id_grupo] > 0)
                                                ({{$notificacionesPorGrupo[$viaje->id_grupo]}})
                                            @endif
                                        </a>
                                        <div class="btn-group">
                                            <a href="/viajes/modificarViaje/{{ $viaje -> id_grupo }}" class="btn btn-primary btn-sm"> Modificar </a>
                                            <button class="btn btn-danger btn-sm" data-id="{{ $viaje -> id_grupo }}" data-toggle="modal" data-target="#myModal"> Eliminar </button>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Eliminar viaje</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="/viajes/eliminarViaje">
                @csrf
                <div class="modal-body">
                    ¿Estás seguro que quieres eliminarlo?
                    <input type="hidden" id="id_modal" name="id_grupo" value="">
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
