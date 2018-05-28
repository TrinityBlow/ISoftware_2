@extends('layouts.layout')

@section('content')
<div class="card">
    @csrf

    <li class="list-group ml-4 mt-3 mr-4">
        <b> Mis viajes:</b>
        <div class="table-responsive mt-2">
            <table class="table table-bordered text-center" id="dataTable" width="100%" cellspacing="0">
                <tr>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Precio</th>
                    <th>Fecha</th>
                    <th>Tipo de viaje</th>
                    <th>Vehículo a utilizar</th>
                    <th>Acciones</th>
                </tr>
                @foreach ($mis_viajes->reverse() as $viaje)
                    <tr>
                        <td> {{ $viaje -> origen }} </td> 
                        <td> {{ $viaje -> destino }} </td>
                        <td> {{ $viaje -> precio }} </td>
                        <td> {{ $viaje -> fecha }} </td>
                        <td> {{ $viaje -> tipo_viaje }} </td> 
                        <td> Vehículo </td>  
                        <td>
                            <a class="text-center" href="#"><button type="button" class="btn btn-info"> Ver detalles de viajes </button> </a>
                            <a class="text-center" href="/viajes/modificarViaje/{{ $viaje -> id_grupo }}"> <button type="button" class="btn btn-primary"> Modificar </button> </a>
                            <button class="btn btn-danger" data-id="{{ $viaje -> id_grupo }}" data-toggle="modal" data-target="#eliminarModal"> Eliminar </button> </a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </li>

</div>

<!-- Modal -->
<div class="modal fade" id="eliminarModal" tabindex="-1" role="dialog" aria-labelledby="modalCenterTitle" aria-hidden="true">
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
